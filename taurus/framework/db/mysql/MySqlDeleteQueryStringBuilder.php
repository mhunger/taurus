<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 19:04
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\DeleteQueryStringBuilder;
use taurus\framework\util\MysqlUtils;


class MySqlDeleteQueryStringBuilder implements DeleteQueryStringBuilder
{
    const MYSQL_KEYWORD_DELETE = 'DELETE FROM';
    const MYSQL_KEYWORD_FUNC_IN = 'IN';

    /**
     * @var MysqlUtils
     */
    private $utils;

    /**
     * MySqlDeleteQueryStringBuilder constructor.
     * @param MysqlUtils $utils
     */
    public function __construct(MysqlUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * @param DeleteQuery $deleteQuery
     * @return string
     */
    public function getDeleteQueryString(DeleteQuery $deleteQuery): string
    {
        $token = [];
        $token[] = self::MYSQL_KEYWORD_DELETE;
        $token[] = $this->utils->addMysqlTicks($deleteQuery->getTable());
        $token[] = MySqlQueryStringBuilderImpl::MYSQL_KEYWORD_WHERE;
        $token[] = $this->utils->addMysqlTicks($deleteQuery->getIdField());

        if (count($deleteQuery->getId()) > 1) {
            $token[] = self::MYSQL_KEYWORD_FUNC_IN;
        } else {
            $token[] = '=';
        }

        $token[] = $this->getWhereForDelete($deleteQuery->getId());

        return implode(' ', $token);

    }

    /**
     * @param array $ids
     * @return string
     */
    private function getWhereForDelete(array $ids): string
    {
        if (count($ids) > 1) {
            return '(' . implode(', ', $ids) . ')';
        }

        return $ids[0];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:51
 */

namespace taurus\framework\db\mysql;


use function PHPSTORM_META\elementType;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\InsertQueryStringBuilder;
use taurus\framework\util\MysqlUtils;

class MysqlInsertQueryStringBuilder implements InsertQueryStringBuilder
{

    const MYSQL_KEY_WORD_INSERT = 'INSERT INTO';

    const MYSQL_KEY_WORD_VALUES = 'VALUES';

    /**
     * @var MysqlUtils
     */
    private $utils;

    /**
     * MysqlInsertQueryStringBuilder constructor.
     *
     * @param MysqlUtils $utils
     */
    public function __construct(MysqlUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * @param InsertQuery $insertQuery
     * @return string
     */
    public function getInsertQueryString(InsertQuery $insertQuery)
    {
        $tokens = [];

        $tokens[] = self::MYSQL_KEY_WORD_INSERT;
        $tokens[] = $this->utils->addMysqlTicks($insertQuery->getTable());
        $tokens[] = '(' . $this->prepareFieldList($insertQuery->getInsertFields()) . ')';
        $tokens[] = self::MYSQL_KEY_WORD_VALUES;
        $tokens[] = '(' . $this->getValues($insertQuery->getValues()) . ')';

        return implode(' ', $tokens);
    }

    /**
     * Add ticks and escape values
     *
     * @param array $values
     * @return array|string
     */
    private function prepareFieldList(array $values)
    {
        return implode(', ', $this->utils->addMysqlTicks($values));
    }

    /**
     * @param array $values
     * @return string
     */
    private function getValues(array $values)
    {
        $tokens = [];

        foreach ($values as $value) {

            $token = $value;

            if (is_null($value)) {
                $token = 'null';
            }

            if (is_string($value)) {
                $token = "'$value'";
            }

            $tokens[] = $token;
        }

        return implode(', ', $tokens);
    }
}

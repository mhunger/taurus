<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:51
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\InsertQueryStringBuilder;

class MysqlInsertQueryStringBuilder implements InsertQueryStringBuilder
{

    const MYSQL_KEY_WORD_INSERT = 'INSERT INTO';

    const MYSQL_KEY_WORD_VALUES = 'VALUES';

    /**
     * @param InsertQuery $insertQuery
     * @return string
     */
    public function getInsertQueryString(InsertQuery $insertQuery)
    {
        $tokens = [];

        $tokens[] = self::MYSQL_KEY_WORD_INSERT;
        $tokens[] = $insertQuery->getTable();
        $tokens[] = '(' . implode(', ', $insertQuery->getInsertFields()) . ')';
        $tokens[] = self::MYSQL_KEY_WORD_VALUES;
        $tokens[] = '(' . $this->getValues($insertQuery->getValues()) . ')';

        return implode(' ', $tokens);
    }

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

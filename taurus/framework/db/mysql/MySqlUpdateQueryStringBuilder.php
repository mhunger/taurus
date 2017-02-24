<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 22:07
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\UpdateQuery;
use taurus\framework\db\query\UpdateQueryStringBuilder;

class MySqlUpdateQueryStringBuilder implements UpdateQueryStringBuilder
{

    const MYSQL_KEYWORD_UPDATE = 'UPDATE';

    const MYSQL_KEYWORD_SET = 'SET';

    public function getUpdateQueryString(UpdateQuery $updateQuery): string
    {
        $tokens = [];
        $tokens[] = self::MYSQL_KEYWORD_UPDATE;
        $tokens[] = $updateQuery->getTable();
        $tokens[] = self::MYSQL_KEYWORD_SET;
        $tokens[] = $this->buildEqualityStrings($updateQuery->getUpdates(), ', ');
        $tokens[] = MySqlQueryStringBuilderImpl::MYSQL_KEYWORD_WHERE;
        $tokens[] = $this->buildEqualityStrings($updateQuery->getWhere(), ' AND ');

        return implode(' ', $tokens);

    }

    private function buildEqualityStrings(array $input, $glue): string
    {
        $tokens = [];
        foreach ($input as $field => $value) {
            if (is_string($value)) {
                $tokens[] = "$field = '$value'";
            } else {
                $tokens[] = "$field = $value";
            }
        }

        return implode($tokens, $glue);
    }
}

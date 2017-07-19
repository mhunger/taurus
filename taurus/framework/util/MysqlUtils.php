<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 19/07/17
 * Time: 14:41
 */

namespace taurus\framework\util;


use taurus\framework\db\mysql\MySqlConnection;

class MysqlUtils
{

    /**
     * @param $mysqlToken
     * @return array|string
     */
    public function addMysqlTicks($mysqlToken) {
        if(is_array($mysqlToken)) {
            $mysqlToken = array_map(array($this, 'addMysqlTicks'), $mysqlToken);
        } else {
            $mysqlToken = '`' . $mysqlToken . '`';
        }

        return $mysqlToken;
    }


    /**
     * Apply escape on values for mysql
     *
     * @param $values
     * @return array
     */
    public function mysqlEscapeValues($values): array {
         return array_map(
            function($v) {
                return mysql_escape_string($v);
            },
            $values
        );
    }
}

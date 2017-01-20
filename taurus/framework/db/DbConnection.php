<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/01/17
 * Time: 22:47
 */

namespace taurus\framework\db;


interface DbConnection {

    public function fetchObjects($sql, $class = null);

    public function execute($sql);
}
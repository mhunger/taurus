<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/01/17
 * Time: 22:47
 */

namespace taurus\framework\db;


use taurus\framework\db\query\Query;

interface DbConnection {

    public function fetchObjects($sql, $class = null);

    public function executeRaw($sql);

    public function execute(Query $query);
}
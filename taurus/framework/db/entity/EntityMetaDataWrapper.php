<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 20:22
 */

namespace taurus\framework\db\entity;


interface EntityMetaDataWrapper
{

    public function getIdField($class);

    public function getTable($class);
}
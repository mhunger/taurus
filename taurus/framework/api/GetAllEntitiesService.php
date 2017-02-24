<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 19:51
 */

namespace taurus\framework\api;


interface GetAllEntitiesService
{
    /**
     * @return array
     */
    public function getAllEntities(): array;

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void;
}
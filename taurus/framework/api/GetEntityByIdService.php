<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 20:33
 */

namespace taurus\framework\api;


use taurus\framework\db\Entity;

interface GetEntityByIdService
{
    /**
     * @param int $id
     * @return Entity
     */
    function getEntityById(int $id): Entity;

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void;
}
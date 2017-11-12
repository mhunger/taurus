<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 19:51
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;

interface GetAllEntitiesService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllEntities(Request $request): array;

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void;
}
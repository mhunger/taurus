<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 19:32
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;

interface SaveEntityService
{
    /**
     * @param Request $request
     */
    public function saveEntity(Request $request);

    /**
     * @param string $entityClass
     * @return mixed
     */
    public function setEntityClass(string $entityClass): void;
}
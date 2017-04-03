<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:20
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;

interface GetBySpecificationService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getResultByRequest(Request $request): array ;

    /**
     * @param string $entityClass
     */
    public function setSpecificationClass(string $entityClass): void;

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void;
}

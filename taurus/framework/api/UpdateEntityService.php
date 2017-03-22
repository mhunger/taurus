<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 19:44
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;

interface UpdateEntityService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function updateEntity(Request $request);

    /**
     * @param string $class
     * @return mixed
     */
    public function setEntityClass(string $class);
}
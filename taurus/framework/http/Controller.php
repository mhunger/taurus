<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:21
 */
namespace taurus\framework\http;

use taurus\framework\routing\Request;

interface Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request);
}
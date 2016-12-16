<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:21
 */
namespace taurus\framework;

use taurus\framework\routing\Request;

interface HttpGetRequest {
    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request);
}
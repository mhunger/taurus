<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/10/17
 * Time: 15:05
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;

interface AuthenticationHandlerService
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleAuthentication(Request $request): mixed;
}
<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:39
 */

namespace taurus\framework\security;


use taurus\framework\routing\Request;

interface AuthenticationService
{
    public function authenticate(Request $request): Token;

}
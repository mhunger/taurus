<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/10/17
 * Time: 12:35
 */

namespace taurus\framework\security;


interface AuthenticationResource
{

    /**
     * Return the password hash value. This would usually simply translate to a getter of the password field.
     *
     * @return string
     */
    public function getPassword(): string;
}

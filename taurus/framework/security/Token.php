<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:41
 */

namespace taurus\framework\security;


Interface Token
{

    /**
     * Returns data from token, usually this will be user data. The data will be of class $taurusConfig->userClass
     *
     * @return mixed
     */
    public function getData(): mixed;

    /**
     * Returns the decoded JWT that is then used to secure each channels
     *
     * @return string
     */
    public function getEncodedTokenString(): string;

    /**
     * Set the data that was encoded in JWT
     *
     * @param mixed $data
     * @return mixed
     */
    public function setData(mixed $data);

    /**
     * Set the encoded string that was encoded by JWT
     *
     * @param string $tokenString
     * @return mixed
     */
    public function setEncodedTokenString(string $tokenString);
}

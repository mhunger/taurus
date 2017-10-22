<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:42
 */

namespace taurus\framework\security;


class StandardTokenImpl implements Token
{
    /** @var mixed */
    private $data;

    /** @var string */
    private $encodedTokenString;

    /**
     * StandardTokenImpl constructor.
     * @param mixed $data
     * @param string $encodedTokenString
     */
    public function __construct($data = null, string $encodedTokenString = null)
    {
        $this->data = $data;
        $this->encodedTokenString = $encodedTokenString;
    }


    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getEncodedTokenString(): string
    {
        return $this->encodedTokenString;
    }

    /**
     * Set the user data in the token. This will usually be an entity of the class defined to hold
     * user info.
     *
     * @param $data
     * @return mixed|void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param string $encodedTokenString
     * @return mixed|void
     */
    public function setEncodedTokenString(string $encodedTokenString)
    {
        $this->encodedTokenString = $encodedTokenString;
    }
}

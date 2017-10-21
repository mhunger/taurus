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
     * @param mixed $data
     * @return mixed|void
     */
    public function setData(mixed $data)
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

<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/10/17
 * Time: 14:07
 */

namespace taurus\tests\testmodel;


use taurus\framework\db\query\Specification;

class UserAuthTestSpecification implements Specification
{

    /**
     * @var string
     *
     * @Spec(column="username", filterType="equals", argumentType="string")
     */
    private $username;

    /**
     * UserAuthTestSpecification constructor.
     * @param string $username
     */
    public function __construct(string $username = null)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return User::USER_TABLE_NAME;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getSelect(): ?array
    {
        return null;
    }
}

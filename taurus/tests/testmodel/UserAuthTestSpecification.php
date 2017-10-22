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
     * @Spec(column="username", type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @Spec(column="password", type="string")
     */
    private $password;

    /**
     * UserAuthTestSpecification constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username = null, string $password = null)
    {
        $this->username = $username;
        $this->password = $password;
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}

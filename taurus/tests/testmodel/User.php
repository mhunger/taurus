<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:35
 */

namespace taurus\tests\testmodel;

use taurus\framework\db\Entity;
use taurus\framework\security\AuthenticationResource;

/**
 * Class User
 * @package legaltech\user
 *
 * @Entity(table="user")
 */
class User implements Entity, AuthenticationResource
{
    const USER_TABLE_NAME = 'user';

    /**
     * @var int
     * @Id
     * @Column(name="id_user")
     */
    public $id;

    /**
     * @var string
     * @Column(name="username")
     */
    public $username;

    /**
     * @var string
     * @Column(name="password")
     * @PasswordHash(algo="PASSWORD_BCRYPT", cost="12")
     */
    public $password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
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
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
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
     * @return User
     */
    public function setPassword(string $password = null): User
    {
        $this->password = $password;
        return $this;
    }
}

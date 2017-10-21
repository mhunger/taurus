<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:35
 */

namespace taurus\tests\testmodel;

use taurus\framework\db\Entity;


/**
 * Class User
 * @package legaltech\user
 *
 * @Entity(table="user")
 */
class User implements Entity
{
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
     */
    public $password;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
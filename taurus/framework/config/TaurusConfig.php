<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:23
 */

namespace taurus\framework\config;


use taurus\tests\testmodel\User;

class TaurusConfig implements Config
{
    const TAURUS_CONFIG_SECRET_KEY = 'cnf_secret_key';

    const TAURUS_CONFIG_TOKEN_TYPE_HEADER = 'cnf_token_type_header';

    const TAURUS_CONFIG_TOKEN_TYPE_COOKIE = 'cnf_token_type_cookie';

    const TAURUS_CONFIG_TOKEN_TYPE = 'cnf_token_type';

    const TAURUS_CONFIG_TOKEN_NAME = 'cnf_token_name';

    const TAURUS_CONFIG_TOKEN_ALGORITHM = 'algorithm';

    const TAURUS_CONFIG_TOKEN_ALGORITHM_HS256 = 'HS256';

    const TAURUS_CONFIG_AUTHENTICATION_URL = 'authurl';

    const TAURUS_CONFIG_USERNAME_PARAM = 'user';

    const TAURUS_CONFIG_PASSWORD_PARAM = 'pw';

    const TAURUS_AUTH_USER_ENTITY = 'auth_user_entity';

    /**
     * This is the key used for the self-signed token
     *
     * @var string
     */
    private $secretKey = 'blabla';

    /**
     * the parameter used to read the user in the login request
     *
     * @var string
     */
    private $usernameParameter = 'username';

    /**
     * The parameter used to read the password in the login request
     * @var string
     */
    private $passwordParameter = 'password';

    /**
     * Class of the user entity
     *
     * @var string
     */
    private $userEntity = User::class;

    /**
     * Where to read the token. Can be cooke or header
     * @var string
     */
    private $tokenType = self::TAURUS_CONFIG_TOKEN_TYPE_HEADER;

    /**
     * Name of the header of cookie, where the token can be found
     * @var string
     */
    private $tokenParamName = 'x-token';

    /**
     * The algorithms used for token signing
     *
     * @var string
     */
    private $tokenAlgorithm = self::TAURUS_CONFIG_TOKEN_ALGORITHM_HS256;

    /**
     * Url on which to authenticate with username and password
     *
     * @var string
     */
    private $authenticationUrl = 'user/login';

    /**
     * @param string $name
     * @return mixed
     */
    public function getConfig(string $name)
    {
        switch ($name) {
            case self::TAURUS_CONFIG_SECRET_KEY:
                return $this->getSecretKey();
                break;
            case self::TAURUS_CONFIG_TOKEN_TYPE:
                return $this->getTokenType();
                break;
            case self::TAURUS_CONFIG_TOKEN_NAME:
                return $this->getTokenParamName();
                break;
            case self::TAURUS_CONFIG_TOKEN_ALGORITHM:
                return $this->getTokenAlgorithm();
                break;
            case self::TAURUS_CONFIG_AUTHENTICATION_URL:
                return $this->getAuthenticationUrl();
                break;
            case self::TAURUS_CONFIG_USERNAME_PARAM:
                return $this->getUsernameParameter();
                break;
            case self::TAURUS_CONFIG_PASSWORD_PARAM:
                return $this->getPasswordParameter();
                break;
            case self::TAURUS_AUTH_USER_ENTITY:
                return $this->getUserEntity();
                break;
            default:
                return null;
        }
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getUsernameParameter(): string
    {
        return $this->usernameParameter;
    }

    /**
     * @return string
     */
    public function getPasswordParameter(): string
    {
        return $this->passwordParameter;
    }

    /**
     * @return string
     */
    public function getUserEntity(): string
    {
        return $this->userEntity;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @return string
     */
    public function getTokenParamName(): string
    {
        return $this->tokenParamName;
    }

    /**
     * @return string
     */
    public function getTokenAlgorithm(): string
    {
        return $this->tokenAlgorithm;
    }

    /**
     * @return string
     */
    public function getAuthenticationUrl(): string
    {
        return $this->authenticationUrl;
    }
}

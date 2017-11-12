<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:23
 */

namespace taurus\framework\config;


use taurus\tests\testmodel\User;
use taurus\tests\testmodel\UserAuthTestSpecification;

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

    const TAURUS_AUTH_USER_QUERY_SPECIFICATION = 'auth_user_specification';

    const TAURUS_AUTH_PUBLIC_RESOURCES = 'auth_pub_res';

    const TAURUS_AUTH_STATUS = 'auth_status';

    const TAURUS_DEFAULT_PAGE_SIZE = 'default_page_size';

    const TAURUS_PAGE_SIZE_PARAM_NAME = 'page_size_param_name';

    const TAURUS_PAGE_PARAM_NAME = 'page_param_name';


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
    private $authenticationUrl = '/user/login';

    /**
     * The specification to build the query to authentication the user, when he logs in
     *
     * @var string
     */
    private $authUserSpecification = UserAuthTestSpecification::class;

    /** @var int */
    private $defaultPageSize = 20;

    /** @var string */
    private $defaultPageSizeParamName = 'pageSize';

    /** @var string */
    private $defaultPageParamName = 'page';

    /** @var array */
    private $publicResources = [
        '/api/users',
        '/api/exercises',
        '/api/exercise',
        '/api/exercisesByDateAndLocation'
    ];

    /** @var bool */
    private $auth = true;


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
            case self::TAURUS_AUTH_USER_QUERY_SPECIFICATION:
                return $this->getAuthUserSpecification();
                break;
            case self::TAURUS_AUTH_PUBLIC_RESOURCES:
                return $this->getPublicResources();
                break;
            case self::TAURUS_AUTH_STATUS:
                return $this->isAuth();
                break;
            case self::TAURUS_DEFAULT_PAGE_SIZE:
                return $this->getDefaultPageSize();
                break;
            case self::TAURUS_PAGE_SIZE_PARAM_NAME:
                return $this->getDefaultPageParamName();
                break;
            case self::TAURUS_PAGE_PARAM_NAME:
                return $this->getDefaultPageParamName();
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

    /**
     * @return string
     */
    public function getAuthUserSpecification(): string
    {
        return $this->authUserSpecification;
    }

    /**
     * @return array
     */
    public function getPublicResources(): array
    {
        return $this->publicResources;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->auth;
    }

    /**
     * @return int
     */
    public function getDefaultPageSize(): int
    {
        return $this->defaultPageSize;
    }

    /**
     * @return string
     */
    public function getDefaultPageSizeParamName(): string
    {
        return $this->defaultPageSizeParamName;
    }

    /**
     * @return string
     */
    public function getDefaultPageParamName(): string
    {
        return $this->defaultPageParamName;
    }
}

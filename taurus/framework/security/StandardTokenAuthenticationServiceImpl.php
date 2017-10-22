<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:40
 */

namespace taurus\framework\security;


use Firebase\JWT\JWT;
use taurus\framework\config\TaurusConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\error\Http401UnauthorisedException;
use taurus\framework\routing\Request;

class StandardTokenAuthenticationServiceImpl implements AuthenticationService
{

    /** @var TaurusConfig */
    private $taurusConfig;

    /** @var Token */
    private $token;

    /** @var BaseRepository */
    private $baseRepository;

    /**
     * StandardTokenAuthenticationServiceImpl constructor.
     * @param TaurusConfig $taurusConfig
     * @param Token $token
     * @param BaseRepository $baseRepository
     */
    public function __construct(TaurusConfig $taurusConfig, Token $token, BaseRepository $baseRepository)
    {
        $this->taurusConfig = $taurusConfig;
        $this->token = $token;
        $this->baseRepository = $baseRepository;
    }

    /**
     * @param Request $request
     * @return Token
     */
    public function authenticate(Request $request): Token
    {
        if($request->getUrl() == $this->taurusConfig->getAuthenticationUrl()) {
            $this->authenticateUsernameAndPassword($request);
        } else {
            $this->authenticateToken($request);
        }

        return $this->token;
    }

    /**
     * @param Request $request
     * @return StandardTokenImpl
     * @throws Http401UnauthorisedException
     */
    private function authenticateToken(Request $request)
    {
        if ($this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_TOKEN_TYPE)
            == TaurusConfig::TAURUS_CONFIG_TOKEN_TYPE_HEADER
        ) {
            $tokenValue = $request->getHeader($this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_TOKEN_NAME));

            $decodedToken = JWT::decode(
                $tokenValue,
                $this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_SECRET_KEY),
                [$this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_TOKEN_ALGORITHM)]
            );

            if($decodedToken == null) {
                throw new Http401UnauthorisedException("Failed to Login");
            }

            $this->token->setData($decodedToken);
        }
    }

    /**
     * Authenticate username/password, encode JWT and set it into the token.
     *
     * @param Request $request
     * @return bool|mixed
     * @throws Http401UnauthorisedException
     */
    private function authenticateUsernameAndPassword(Request $request): bool
    {
        $username = $request->getBodyParamByName(
            $this->taurusConfig->getUsernameParameter()
        );

        $password = $request->getBodyParamByName(
            $this->taurusConfig->getPasswordParameter()
        );

        /**
         * @TODO remove fix ID here with making real request. Implement findBy in base repo first.
         */
        $authenticatedUser = $this->baseRepository->findOne(1, $this->taurusConfig->getConfig(TaurusConfig::TAURUS_AUTH_USER_ENTITY));

        if($authenticatedUser === null) {
            throw new Http401UnauthorisedException('Username and Password unauthorised');
        }

        $this->token->setData($authenticatedUser);

        $this->token->setEncodedTokenString(
            JWT::encode(
                $authenticatedUser,
                $this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_SECRET_KEY)
            )
        );

        return true;
    }
}

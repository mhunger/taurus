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
use taurus\framework\error\Http401UnauthorisedException;
use taurus\framework\routing\Request;

class StandardTokenAuthenticationServiceImpl implements AuthenticationService
{

    /** @var TaurusConfig */
    private $taurusConfig;

    /** @var Token */
    private $token;

    /**
     * StandardTokenAuthenticationServiceImpl constructor.
     * @param TaurusConfig $taurusConfig
     * @param Token $token
     */
    public function __construct(TaurusConfig $taurusConfig, Token $token)
    {
        $this->taurusConfig = $taurusConfig;
        $this->token = $token;
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
     * @return mixed
     */
    private function authenticateUsernameAndPassword(Request $request): mixed
    {
        $username = $request->getBodyParamByName(
            $this->taurusConfig->getUsernameParameter()
        );

        $password = $request->getBodyParamByName(
            $this->taurusConfig->getPasswordParameter()
        );

        //here check with db whether combo exists. Need to think how to do this.

        //if exists

        $this->token->setEncodedTokenString(
            JWT::encode(
                ['username' => $username, 'password' => $password],
                $this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_SECRET_KEY),
                [$this->taurusConfig->getConfig(TaurusConfig::TAURUS_CONFIG_TOKEN_ALGORITHM)]
            )
        );
    }
}

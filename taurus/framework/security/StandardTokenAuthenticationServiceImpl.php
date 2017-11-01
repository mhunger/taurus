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
use taurus\framework\db\query\SpecificationBuilder;
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

    /** @var SpecificationBuilder */
    private $specificationBuilder;

    /**
     * StandardTokenAuthenticationServiceImpl constructor.
     * @param TaurusConfig $taurusConfig
     * @param Token $token
     * @param BaseRepository $baseRepository
     * @param SpecificationBuilder $specificationBuilder
     */
    public function __construct(
        TaurusConfig $taurusConfig,
        Token $token,
        BaseRepository $baseRepository,
        SpecificationBuilder $specificationBuilder
    ) {
        $this->taurusConfig = $taurusConfig;
        $this->token = $token;
        $this->baseRepository = $baseRepository;
        $this->specificationBuilder = $specificationBuilder;
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

            if(empty($tokenValue)) {
                throw new Http401UnauthorisedException('Token missing');
            }

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
        $authenticatedUsers = $this->baseRepository->findBySpecification(
            $this->specificationBuilder->build(
                $request,
                $this->taurusConfig->getConfig(TaurusConfig::TAURUS_AUTH_USER_QUERY_SPECIFICATION)
            ),
            $this->taurusConfig->getConfig(TaurusConfig::TAURUS_AUTH_USER_ENTITY)
        );

        if(empty($authenticatedUsers) || sizeof($authenticatedUsers) > 1) {
            throw new Http401UnauthorisedException('Username and Password unauthorised');
        }

        /** @var AuthenticationResource $authenticatedUser */
        $authenticatedUser = $authenticatedUsers[0];

        if (!password_verify(
                $request->getBodyParamByName($this->taurusConfig->getPasswordParameter()),
                $authenticatedUser->getPassword()
            )
        ) {
            throw new Http401UnauthorisedException('Unauthorised User');
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

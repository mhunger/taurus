<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/10/17
 * Time: 14:59
 */

namespace taurus\framework\api;


use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

/**
 * Class AuthenticationController
 * @package taurus\framework\api
 *
 * Controller that is executed, when authentication url is called.
 *
 * The authentication will already authenticate using the entity configured and return token.
 *
 * If you want any additional information, implement interface AuthenticationController and configure it
 * in the route config.
 */
class AuthenticationController implements Controller
{

    /** @var AuthenticationHandlerService */
    private $authenticationHandlerService;

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request): mixed
    {
        return $this->authenticationHandlerService->handleAuthentication($request);
    }

    /**
     * @param AuthenticationHandlerService $authenticationHandlerService
     */
    public function setAuthenticationHandlerService(AuthenticationHandlerService $authenticationHandlerService)
    {
        $this->authenticationHandlerService = $authenticationHandlerService;
    }
}
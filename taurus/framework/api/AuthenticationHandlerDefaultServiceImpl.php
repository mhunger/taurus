<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/10/17
 * Time: 15:06
 */

namespace taurus\framework\api;


use taurus\framework\routing\Request;
use taurus\framework\security\Token;

class AuthenticationHandlerDefaultServiceImpl implements AuthenticationHandlerService
{
    /** @var Token */
    private $token;

    /**
     * AuthenticationHandlerDefaultServiceImpl constructor.
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleAuthentication(Request $request): mixed
    {
        return $this->token->getData();
    }
}

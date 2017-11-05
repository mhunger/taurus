<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:18
 */

namespace taurus\framework\routing;

use taurus\framework\config\TaurusConfig;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Environment;
use taurus\framework\error\Http401UnauthorisedException;
use taurus\framework\error\Http404NotFoundException;
use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\http\HttpJsonResponse;
use taurus\framework\security\AuthenticationService;
use taurus\framework\security\StandardTokenAuthenticationServiceImpl;
use taurus\framework\security\Token;

class Router
{
    /** @var RouteConfig */
    private $routeConfig;

    /** @var bool */
    private $requestHandled = false;

    /** @var Environment */
    private $environment;

    /** @var AuthenticationService */
    private $authenticationService;

    /** @var Token */
    private $token;

    /** @var TaurusConfig */
    private $taurusConfig;

    /**
     * @param RouteConfig $routeConfig
     * @param Environment $environment
     * @param AuthenticationService $authenticationService
     * @param Token $token
     * @param TaurusConfig $taurusConfig
     */
    public function __construct(
        RouteConfig $routeConfig,
        Environment $environment,
        AuthenticationService $authenticationService,
        Token $token,
        TaurusConfig $taurusConfig
    ) {
        $this->routeConfig = $routeConfig;
        $this->environment = $environment;
        $this->authenticationService = $authenticationService;
        $this->token = $token;
        $this->taurusConfig = $taurusConfig;
    }

    /**
     * @param Request $request
     * @return HttpJsonResponse
     * @throws \Exception
     */
    public function route(Request $request)
    {

        $url = $request->getUrl();
        $method = $request->getMethod();

        try {
            $this->authenticate($request);
            $controller = $this->routeConfig->getRoute($method, $url);
            $body = $controller->handleRequest($request);

            if ($this->isTestEnvironment()) {
                $this->requestHandled = true;

                return new HttpJsonResponse(
                    201,
                    $body,
                    Request::HTTP_CONTENT_TYPE_APPLICATION_JSON,
                    $this->addToken()
                );
            } else {
                (new HttpJsonResponse(
                    201,
                    $body,
                    Request::HTTP_CONTENT_TYPE_APPLICATION_JSON,
                    $this->addToken())
                )->send();
                $this->requestHandled = true;
            }
        } catch (RouteNotFoundException $e) {
            if (!$this->isTestEnvironment()) {
                (new HttpJsonResponse(404, $e->getMessage()))->send();
            }
            throw $e;
        } catch (Http404NotFoundException $e) {
            if (!$this->isTestEnvironment()) {
                (new HttpJsonResponse(404, $e->getMessage()))->send();
            }
            throw $e;
        } catch(Http401UnauthorisedException $e) {
            if(!$this->isTestEnvironment()) {
                (new HttpJsonResponse(401, $e->getMessage()))->send();
            }
            throw $e;
        } catch (\Exception $ex) {
            if (!$this->isTestEnvironment()) {
                (new HttpJsonResponse(500, $ex->getMessage()))->send();
            }
            throw $ex;
        }
    }

    /**
     * @param Request $request
     * @return Token
     */
    private function authenticate(Request $request): Token
    {

        if(!in_array($request->getUrl(), $this->taurusConfig->getConfig(TaurusConfig::TAURUS_AUTH_PUBLIC_RESOURCES))
            && $this->taurusConfig->getConfig(TaurusConfig::TAURUS_AUTH_STATUS) == true) {

            /** @var StandardTokenAuthenticationServiceImpl $authenticationService */
            return $this->authenticationService->authenticate($request);
        }

        return $this->token;
    }

    /**
     * @return array
     */
    private function addToken(): array
    {
        if($this->token->isAuthenticated()) {
            return [
                $this->taurusConfig->getTokenParamName() => $this->token->getEncodedTokenString()
            ];
        }

        return [];
    }

    /**
     * @return bool
     */
    public function isTestEnvironment()
    {
        return $this->environment->getName() === Environment::TEST;
    }

    /**
     * @return boolean
     */
    public function isRequestHandled()
    {
        return $this->requestHandled;
    }
}

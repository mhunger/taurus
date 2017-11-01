<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/10/17
 * Time: 16:48
 */

namespace taurus\tests\security;


use Firebase\JWT\JWT;
use taurus\framework\config\TaurusConfig;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\mock\MockRequest;
use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\framework\security\StandardTokenAuthenticationServiceImpl;
use taurus\framework\security\StandardTokenImpl;
use taurus\framework\security\Token;
use taurus\tests\AbstractTaurusDatabaseTest;
use taurus\tests\testmodel\User;

class StandardTokenAuthenticationServiceImplTest extends AbstractTaurusDatabaseTest
{
    /** @var StandardTokenAuthenticationServiceImpl */
    private $authenticationService;

    public function setUp()
    {
        parent::setUp();

        $this->authenticationService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_STANDARD_AUTHENTICATION_SERVICE);
    }

    /**
     * @return array
     */
    public function getFixtureFiles(): array
    {
        return [
            'user.xml'
        ];
    }

    public function testUsernamePasswordAuthentication()
    {
        $this->assertEquals(
            new StandardTokenImpl(
                $this->buildUser(1, 'mike', '$2y$12$uSMt.tn4X2TF0Z24/gYDuejZ97Vn37qNTXRwTQFlAed35MIbFUlDm'),
                JWT::encode(
                    $this->buildUser(1, 'mike', '$2y$12$uSMt.tn4X2TF0Z24/gYDuejZ97Vn37qNTXRwTQFlAed35MIbFUlDm'),
                    Container::getInstance()->getService(TaurusContainerConfig::SERVICE_TAURUS_CONFIG)
                        ->getConfig(TaurusConfig::TAURUS_CONFIG_SECRET_KEY)
                )),
            $this->login(),
            'Could not login correctly with username & password. Token or userdata not matching'
        );
    }

    public function testTokenAuthentication()
    {

        $token = $this->login();

        /** @var MockRequest $mockRequest */
        $mockRequest = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST);
        $mockRequest->setHeader('x-token',  $token->getEncodedTokenString())
            ->setUrl('/api/user?id=1')
            ->setMethod(Request::HTTP_GET);

        $this->assertEquals(
            $token,
            $this->authenticationService->authenticate($mockRequest),
            'Could not verify token successful.'
        );


    }

    /**
     * @param int $id
     * @param string $user
     * @param string $pw
     * @return User
     */
    private function buildUser(int $id, string $user, string $pw)
    {
        return (new User())->setId($id)
            ->setUsername($user)
            ->setPassword($pw);
    }

    private function login(): Token
    {
        /** @var MockRequest $mockRequest */
        $mockRequest = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST);
        $mockRequest->setInputBody(
            [
                'username' => 'mike',
                'password' => 'mike123'
            ]
        )->setUrl('/user/login')
            ->setMethod(Request::HTTP_POST);

        return $this->authenticationService->authenticate($mockRequest);
    }
}
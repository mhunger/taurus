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
        /** @var MockRequest $mockRequest */
        $mockRequest = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MOCK_REQUEST);
        $mockRequest->setInputBody(
            [
                'username' => 'mike',
                'password' => 'mike123'
            ]
        )->setUrl('/user/login')
        ->setMethod(Request::HTTP_POST);

        $this->assertEquals(
            new StandardTokenImpl(
                $this->buildUser(1, 'mike', 'mike123'),
                JWT::encode(
                    $this->buildUser(1, 'mike', 'mike123'),
                    Container::getInstance()->getService(TaurusContainerConfig::SERVICE_TAURUS_CONFIG)
                        ->getConfig(TaurusConfig::TAURUS_CONFIG_SECRET_KEY)
                )),
            $this->authenticationService->authenticate($mockRequest),
            'Could not login correctly with username & password. Token or userdata not matching'
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

}
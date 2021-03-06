<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/10/17
 * Time: 15:28
 */

namespace taurus\tests\api;


use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\error\Http401UnauthorisedException;
use taurus\framework\mock\MockServer;
use taurus\tests\AbstractTaurusDatabaseTest;

class AuthenticationLoginTest extends AbstractTaurusDatabaseTest
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     */
    function getFixtureFiles(): array
    {
        return [
            'user.xml'
        ];
    }

    /**
     * This only tests that we can access the user fixtures for authetication
     */
    public function testGetAllUsers()
    {
        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);

        $actualResponse = $mockServer->get(
            '/api/users',
            'GET',
            []
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not get all users to further test authentication'
        );
    }

    public function testTokenInRequest()
    {
        $token = $this->login();

        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);

        $actualResponse = $mockServer->get(
            '/api/user',
            'GET',
            ['id' => 1],
            [],
            ['x-token' => $token->getEncodedTokenString()]
        );

        $this->compareResultToFixture(
            $actualResponse,
            __FUNCTION__,
            'Could not authenticate user'
        );
    }

    public function testTokenMissingRequest()
    {
        $this->expectException(Http401UnauthorisedException::class);

        /** @var MockServer $mockServer */
        $mockServer = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MOCK_SERVER);

        $mockServer->get(
            '/api/user',
            'GET',
            ['id' => 1],
            []
        );
    }
}

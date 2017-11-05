<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 19:33
 */

namespace taurus\tests;

use taurus\framework\config\TestContainerConfig;
use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\exception\JsonResultsFileNotFoundException;
use taurus\framework\mock\MockRequest;
use taurus\framework\routing\Request;
use taurus\framework\security\StandardTokenAuthenticationServiceImpl;
use taurus\framework\security\Token;

/**
 * Class AbstractTaurusDatabaseTest
 * @package taurus\tests
 */
abstract class AbstractTaurusDatabaseTest extends AbstractDatabaseTest
{
    /** @var StandardTokenAuthenticationServiceImpl */
    protected $authenticationService;

    /** @var array */
    protected $fixtureFiles = [];

    /** @var string */
    protected $fixturePath;

    /**
     * Set the test config in container and load the fixture path.
     */
    public function setUp()
    {
        $this->dbname = 'taurus_test';
        $this->dbuser = 'taurus';
        $this->dbpw= 'taurus';
        $this->dbhost = 'localhost';

        $this->fixturesDbState = '/fixtures/db/';

        $this->fixturesJsonResults = '/fixtures/jsonResults/';

        $config = (new TaurusContainerConfig())
            ->merge(new TestContainerConfig());
        Container::getInstance()->setContainerConfig($config);

        $this->authenticationService = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_STANDARD_AUTHENTICATION_SERVICE);

        parent::setUp();
    }


    /**
     * @return Token
     */
    protected function login(): Token
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

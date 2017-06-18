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

/**
 * Class AbstractTaurusDatabaseTest
 * @package taurus\tests
 */
abstract class AbstractTaurusDatabaseTest extends AbstractDatabaseTest
{

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

        parent::setUp();
    }
}

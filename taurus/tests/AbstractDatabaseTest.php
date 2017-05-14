<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 19:33
 */

namespace taurus\tests;

use fitnessmanager\config\FitnessManagerConfig;
use fitnessmanager\config\test\TestContainerConfig;
use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\exception\JsonResultsFileNotFoundException;

/**
 * Class AbstractDatabaseTest
 * @package taurus\tests
 */
abstract class AbstractDatabaseTest extends \PHPUnit_Extensions_Database_TestCase
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
        $config = (new TaurusContainerConfig())
            ->merge(new FitnessManagerConfig())
            ->merge(new TestContainerConfig());
        Container::getInstance()->setContainerConfig($config);

        parent::setUp();
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        $pdo = new PDO('mysql:dbname=taurus_test;host=localhost', 'taurus', 'taurus');

        return $this->createDefaultDBConnection($pdo, 'taurus_test');
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $datasets = [];
        $this->fixturePath = dirname(__FILE__) . '/fixtures/db/';
        foreach ($this->getFixtureFiles() as $file) {
            $datasets[] = $this->createMySQLXMLDataSet($this->fixturePath . $file);
        }

        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);
    }

    /**
     * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     */
    protected function getTearDownOperation()
    {
        return \PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE();
    }

    /**
     * @param string $class
     * @param string $method
     * @param string $actualResponse
     * @return string
     * @throws JsonResultsFileNotFoundException
     * @internal param string $file
     */
    protected function getOrCreateJsonResultsFilePath(string $class, string $method, string $actualResponse): string
    {
        $filePath = dirname(__FILE__) . '/fixtures/jsonResults/' . basename(str_replace('\\', '/', $class)) . '-' . $method . '.json';

        if (is_file($filePath)) {
            if(getenv('updateResultFiles') == 'true') {

                $this->generateFile($filePath, $actualResponse);
            }
            return $filePath;
        }

        if(getenv('generateResultFiles') == 'true') {
            $this->generateFile($filePath, $actualResponse);
        }

        throw new JsonResultsFileNotFoundException($filePath);
    }

    /**
     * @param string $actualResponse
     * @param string $method
     * @param string $msg
     */
    protected function compareResultToFixture(string $actualResponse, string $method, string $msg)
    {
        $this->assertJsonStringEqualsJsonFile(
            $this->getOrCreateJsonResultsFilePath(static::class, $method, $actualResponse),
            $actualResponse,
            $msg
        );
    }

    private function generateFile(string $filePath, string $actualResponse)
    {
        $f = fopen($filePath, 'w+');
        fwrite($f, $actualResponse);
        fclose($f);

        echo "Written [$filePath]\n";
    }

    /**
     *
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @return array
     */
    abstract function getFixtureFiles(): array;
}

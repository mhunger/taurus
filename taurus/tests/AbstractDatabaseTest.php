<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/17
 * Time: 14:10
 */

namespace taurus\tests;


use PDO;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use taurus\framework\exception\JsonResultsFileNotFoundException;

abstract class AbstractDatabaseTest extends \PHPUnit_Extensions_Database_TestCase
{
    /** @var array */
    protected $fixtureFiles = [];

    /** @var string */
    protected $fixturePath;

    protected $dbname, $dbuser, $dbpw, $dbhost;

    protected $fixturesDbState, $fixturesJsonResults;

    /**
     * Set the test config in container and load the fixture path.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        $pdo = new PDO("mysql:dbname=$this->dbname;host=$this->dbhost", $this->dbuser, $this->dbpw);

        return $this->createDefaultDBConnection($pdo, $this->dbname);
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $datasets = [];
        $this->fixturePath = dirname(__FILE__) . $this->fixturesDbState;
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
        $filePath = dirname(__FILE__) . $this->fixturesJsonResults . basename(str_replace('\\', '/', $class)) . '-' . $method . '.json';

        if (is_file($filePath)) {
            if(getenv('updateResultFiles') == 'TRUE') {

                $this->generateFile($filePath, $actualResponse);
            }
            return $filePath;
        }

        if(strtolower(getenv('generateResultFiles')) == 'true') {
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
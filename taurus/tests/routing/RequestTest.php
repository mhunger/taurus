<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 21:03
 */

namespace taurus\tests\routing;

use PHPUnit\Framework\TestCase;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\routing\Request;
use taurus\tests\fixtures\GlobalVariablesMock;

class RequestTest extends TestCase
{

    /**
     * @var Request
     */
    private $testSubject;

    private $globalVariableMock;

    public function setUp()
    {

        $this->globalVariableMock = new GlobalVariablesMock();
        $this->globalVariableMock->setGlobalVariables();

        $this->testSubject = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_REQUEST);

    }

    public function testGetParamByName()
    {
        $expectedValue = 1;
        $actualValue = $this->testSubject->getRequestParamByName('id');

        $this->assertEquals(
            $expectedValue,
            $actualValue,
            'Could not get correct request parameter value. Got [' . $actualValue . '] expected [' . $expectedValue . ']'
        );
    }

    public function testGetHeader()
    {
        $expected = 'no-cache';

        $this->assertEquals(
            $expected,
            $this->testSubject->getHeader('cache-control'),
            "Could not read correct header for cache-control"
        );
    }
}

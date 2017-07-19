<?php

use taurus\framework\util\MysqlUtils;
use taurus\tests\AbstractTaurusTest;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 19/07/17
 * Time: 14:43
 */
class MysqlUtilsTest extends AbstractTaurusTest
{
    /**
     * @var MysqlUtils
     */
    private $utils;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $conn = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MYSQL_CONNECTION);
        $this->utils = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MYSQL_UTILS);
    }

    public function testAddMysqlTicksWithValue()
    {
        $expected = '`est`';

        $this->assertEquals(
            $expected,
            $this->utils->addMysqlTicks('est'),
            'Could not add mysql ticks correctly'
        );
    }

    public function testAddMySqlTicksToArray()
    {
        $expected = [
            '`value1`',
            '`value2`'
        ];

        $this->assertEquals(
            $expected,
            $this->utils->addMysqlTicks(['value1', 'value2']),
            'Could not add mysql ticks to array'
        );
    }
}
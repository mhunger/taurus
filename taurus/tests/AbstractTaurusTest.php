<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 11/02/17
 * Time: 00:12
 */

namespace taurus\tests;


use fitnessmanager\config\FitnessManagerTestConfig;
use taurus\framework\config\TestContainerConfig;
use PHPUnit\Framework\TestCase;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;

abstract class AbstractTaurusTest extends TestCase
{
    protected function setUp()
    {
        $config = (new TaurusContainerConfig())
            ->merge(new FitnessManagerTestConfig())
            ->merge(new TestContainerConfig());
        Container::getInstance()->setContainerConfig($config);
        parent::setUp();
    }
}

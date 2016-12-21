<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 20:18
 */

namespace taurus\tests\fixtures;


use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;

class TestContainerConfig extends AbstractContainerConfig {

    const SERVICE_TEST_LITERALS = 'taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass';

    public function __construct() {
        $this->serviceDefinitions[self::SERVICE_TEST_LITERALS] =
            new ServiceConfig(
                self::SERVICE_TEST_LITERALS,
                null,
                [
                    0 => 'literal1',
                    2 => 100
                ]
            );
    }
}
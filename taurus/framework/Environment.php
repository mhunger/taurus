<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:17
 */

namespace taurus\framework;


class Environment {

    const DEV = 'DEV';

    const PROD = 'PROD';

    const TEST = 'TEST';

    /** @var string */
    private $env;

    /**
     * @param string $env
     */
    public function __construct($env = Environment::TEST) {
        $this->env = $env;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->env;
    }
}
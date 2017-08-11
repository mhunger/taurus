<?php
namespace bin;
use bin\generator\TaurusGenerator;
use bin\tpl\TaurusInitiator;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\tests\fixtures\TestEntity;

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 06/07/17
 * Time: 13:36
 */
class Taurus
{
    static $validCommands = [
        self::CMD_GENERATE_FE,
        self::CMD_INIT_APP
    ];

    static  $_noisy = true;

    const CMD_INIT_APP = 'init';

    const CMD_GENERATE_FE = 'generate';

    /** @var array */
    private $args;

    /**
     * @var string
     */
    private $cmd;

    /**
     * @var string
     */
    private $argument;

    /**
     * @var TaurusInitiator
     */
    private $initialiser;

    /** @var TaurusGenerator */
    private $generator;

    /**
     * Taurus constructor.
     */
    public function __construct($args)
    {
        $this->args = $args;
        $this->cmd = $args[1];

        $this->checkCommand($this->cmd);
        $this->argument = $args[2];
    }

    public function bootstrap()
    {
        Container::getInstance()->setContainerConfig(
            new TaurusContainerConfig()
        );
        return $this;
    }

    /**
     * @param string $cmd
     * @return bool
     * @throws \Exception
     */
    private function checkCommand(string $cmd): bool
    {
        if(!in_array($cmd, self::$validCommands)) {
            throw new \Exception('No Valid command passed: [' . $cmd . ']');
        }

        return true;
    }

    public function run()
    {
        switch($this->cmd) {
            case self::CMD_INIT_APP:
                $this->initialiser = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_TAURUS_INITIALISER);
                $this->initialiser->initApp($this->argument);
                break;

            case self::CMD_GENERATE_FE:
                $this->generator = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_TAURUS_GENERATOR);
                $this->generator->generateEntity(TestEntity::class);
                break;
        }
    }

    /**
     * @param $message
     * @param $argument
     */
    public static function info($message, $argument)
    {
        if(self::$_noisy) {
            echo $message . ': [' . $argument . ']' . "\n";
        }
    }
}

<?php
namespace bin;
use bin\tpl\TaurusInitiator;

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

    /**
     * Taurus constructor.
     */
    public function __construct($args)
    {
        $this->initialiser = new TaurusInitiator();
        $this->args = $args;
        $this->cmd = $args[1];

        $this->checkCommand($this->cmd);
        $this->argument = $args[2];
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
                $this->initialiser->initApp($this->argument);
                break;

            case self::CMD_GENERATE_FE:
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

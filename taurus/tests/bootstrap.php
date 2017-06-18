<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 13:29
 */

use taurus\Application;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\config\TestContainerConfig;
use taurus\framework\Container;
use taurus\framework\Environment;

require_once __DIR__ . "/../../vendor/autoload.php";
set_include_path(get_include_path() . ".:..");
spl_autoload_register();

$config = new TaurusContainerConfig();

if(getenv('TAURUS_ENV') == Environment::TEST) {
    $config->merge(
        new TestContainerConfig()
    );
}

Container::getInstance()->setContainerConfig($config);
/** @var \taurus\framework\db\mysql\MySqlConnection $mysql */
$mysql = \taurus\framework\Container::getInstance()->getService(\taurus\framework\config\TaurusContainerConfig::SERVICE_MYSQL_CONNECTION);
system('mysql --user=taurus --password=taurus taurus_test < taurus-test-schema.sql');
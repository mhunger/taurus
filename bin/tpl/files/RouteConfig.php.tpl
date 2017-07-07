<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/06/17
 * Time: 20:17
 */

namespace ##app-name##\config;


use taurus\framework\api\ApiBuilder;
use taurus\framework\routing\AbstractRouteConfig;

class ##route-config-class## extends AbstractRouteConfig
{
    const API_BASE_PATH = '##base-path##';

    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        parent::__construct($base, $apiBuilder);
    }
}
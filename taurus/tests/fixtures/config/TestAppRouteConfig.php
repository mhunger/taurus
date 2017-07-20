<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/06/17
 * Time: 20:17
 */

namespace testApp\config;


use taurus\framework\api\ApiBuilder;
use taurus\framework\routing\AbstractRouteConfig;

class TestAppRouteConfig extends AbstractRouteConfig
{
    const API_BASE_PATH = 'api';

    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        parent::__construct($base, $apiBuilder);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:25
 */

namespace taurus\framework\generator;


use taurus\framework\page\AppConfig;
use taurus\framework\page\AppContainer;
use taurus\framework\page\AppContainerBuilder;

class TaurusGenerator
{

    /** @var AppContainer */
    private $appContainer;

    /**
     * TaurusGenerator constructor.
     * @param AppContainerBuilder $appContainerBuilder
     * @param AppConfig $appConfig
     */
    public function __construct(AppContainerBuilder $appContainerBuilder, AppConfig $appConfig)
    {
        $this->appContainer = $appContainerBuilder->build($appConfig);
    }


    public function generateApp()
    {


    }
}
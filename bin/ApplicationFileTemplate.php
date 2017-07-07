<?php

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 07/07/17
 * Time: 09:30
 */
class ApplicationFileTemplate extends AbstractTemplate
{
    function render(): ApplicationFileTemplate
    {
        Taurus::info('Render Application', $this->getTplContent());

        $this->setVars($this->data->getVars());

        return $this;
    }
}

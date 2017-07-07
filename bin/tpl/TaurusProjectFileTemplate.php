<?php

namespace tpl;

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 07/07/17
 * Time: 09:30
 */
class TaurusProjectFileTemplate extends AbstractTemplate
{
    function render(): TaurusProjectFileTemplate
    {
        Taurus::info('Render Application', $this->getTplContent());

        $this->setVars($this->data->getVars());

        return $this;
    }
}

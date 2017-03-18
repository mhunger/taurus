<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 19:43
 */
namespace taurus\framework\annotation;

interface Annotation
{
    /**
     * @return string
     */
    public function getAnnoationName(): string;

    /**
     * @return string
     */
    public function getProperty(): string;
}

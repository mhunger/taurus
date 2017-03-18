<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 20:04
 */

namespace taurus\framework\annotation;


class Id extends AbstractAnnotation
{
    const ANNOTATION_NAME_ID = 'Id';

    public function __construct($property)
    {
        parent::__construct($property, self::ANNOTATION_NAME_ID);
    }
}
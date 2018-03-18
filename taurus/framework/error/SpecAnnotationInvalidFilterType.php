<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/03/18
 * Time: 16:46
 */

namespace taurus\framework\error;


class SpecAnnotationInvalidFilterType extends \Exception
{
    public function __construct(string $filterType)
    {
        parent::__construct('Invalid Filter Type was set in Spec Annotation [' . $filterType . ']', 500);
    }
}

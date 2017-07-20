<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 21:08
 */

namespace taurus\framework\error;


use Exception;

class AnnotationCouldNotBeInstantiatedException extends \Exception
{
    public function __construct(string $annotation, $property, array $args = [])
    {
        $message = 'Could not instantiate annotation [' . $annotation . '] on property: [' . $property . '] with args: [' . implode(', ',
                $args) . '], because of too few arguments';
        parent::__construct($message);
    }

}
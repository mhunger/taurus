<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:00
 */

namespace taurus\framework\error;


class ApiEntityCouldNotBeMappedInPostRequest extends \Exception
{
    public function __construct(string $entityClass)
    {
        parent::__construct("Could not map request to entity: [" . $entityClass . ']');
    }
}
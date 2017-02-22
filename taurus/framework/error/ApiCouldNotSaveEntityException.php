<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:03
 */

namespace taurus\framework\error;


class ApiCouldNotSaveEntityException extends \Exception
{
    public function __construct(string $entity)
    {
        parent::__construct('Could not save entity with name: [' . $entity . ']');
    }

}
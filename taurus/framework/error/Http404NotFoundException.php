<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 23:06
 */

namespace taurus\framework\error;


class Http404NotFoundException extends \Exception
{

    /**
     * Http404NotFoundException constructor.
     * @param string $id
     */
    public function __construct($id, $resource)
    {
        parent::__construct('Resource [' . $resource . '] does not exist for [' . $id . ']');
    }
}
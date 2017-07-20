<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 20/07/17
 * Time: 12:17
 */

namespace taurus\framework\error;


use Exception;
use Throwable;

class MandatoryAnnotationParameterMissing extends Exception
{
    /**
     * MandatoryAnnotationParameterMissing constructor.
     * @param string $parameter
     * @param string $annotation
     */
    public function __construct(string $parameter, string $annotation)
    {
        $msg = 'Mandatory Parameter: [' . $parameter . '] missing to create annoation: [' . $annotation . ']';
        parent::__construct($msg);
    }

}
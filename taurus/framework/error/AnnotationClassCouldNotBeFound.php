<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 20:35
 */

namespace taurus\framework\error;


use Exception;

class AnnotationClassCouldNotBeFound extends \Exception
{
    /**
     * AnnotationClassCouldNotBeFound constructor.
     * @param string $annotation
     */
    public function __construct($annotation)
    {
        $message = 'Could not find class for annotation: [' . $annotation . ']';

        parent::__construct($message);
    }

}
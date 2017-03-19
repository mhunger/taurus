<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/03/17
 * Time: 12:16
 */

namespace taurus\framework\exception;

class JsonResultsFileNotFoundException extends \Exception
{

    /**
     * JsonResultsFileNotFoundException constructor.
     * @param string $file
     */
    public function __construct($file) {
        parent::__construct("Could not find json results file: [" . $file . ']');
    }
}

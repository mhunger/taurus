<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:06
 */

namespace fitnessmanager\workout;

use taurus\framework\HttpGetRequest;
use taurus\framework\routing\Request;

class WorkoutController implements HttpGetRequest{
    public function handleRequest(Request $request)
    {
        $response = new \stdClass();
        $response->text = 'Items GetRequest handled';
        $response->request = $request;

        return $response;
    }
}
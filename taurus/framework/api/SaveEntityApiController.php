<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:34
 */

namespace taurus\framework\api;

use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

class SaveEntityApiController implements Controller
{
    /** @var SaveEntityService */
    private $service;

    /**
     * @param Request $request
     * @return bool
     */
    public function handleRequest(Request $request)
    {
        return $this->service->saveEntity($request);
    }

    /**
     * @param SaveEntityService $service
     */
    public function setService(SaveEntityService $service)
    {
        $this->service = $service;
    }
}

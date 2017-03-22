<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:17
 */

namespace taurus\framework\api;


use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

class UpdateEntityApiController implements Controller
{
    /** @var UpdateEntityService */
    private $service;

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request)
    {
        return $this->service->updateEntity($request);
    }

    /**
     * @param UpdateEntityService $service
     */
    public function setService(UpdateEntityService $service): void
    {
        $this->service = $service;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:20
 */

namespace taurus\framework\api;


use taurus\framework\http\Controller;
use taurus\framework\routing\Request;

class GetBySpecificationApiController implements Controller
{

    /** @var GetBySpecificationService */
    private $getBySpecificationService;

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request)
    {
        return $this->getBySpecificationService->getResultByRequest($request);
    }

    /**
     * @param GetBySpecificationService $getBySpecificationService
     */
    public function setGetBySpecificationService(GetBySpecificationService $getBySpecificationService): void
    {
        $this->getBySpecificationService = $getBySpecificationService;
    }
}

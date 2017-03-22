<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 20:01
 */

namespace taurus\framework\api;

use taurus\framework\error\ApiEntityCouldNotBeMappedInPostRequest;
use taurus\framework\routing\Request;

class RequestEntityMapper
{

    /**
     * @param Request $request
     * @param string $class
     * @return array
     * @throws ApiEntityCouldNotBeMappedInPostRequest
     */
    public function getEntityDataFromRequest(Request $request, string $class): array
    {
        $entityName = $this->getEntityClassName($class);
        if ($request->getBodyParamByName($entityName) !== null) {
            if (is_array($request->getBodyParamByName($entityName))) {
                return $request->getBodyParamByName($entityName);
            }
        }

        throw new ApiEntityCouldNotBeMappedInPostRequest($entityName);
    }

    /**
     * @param string $entityClass
     * @return string
     */
    private function getEntityClassName(string $entityClass): string
    {
        return strtolower(basename(str_replace('\\', '/', $entityClass)));
    }
}

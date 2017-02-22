<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 19:43
 */

namespace taurus\framework\api;


use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\EntityBuilder;
use taurus\framework\error\ApiCouldNotSaveEntityException;
use taurus\framework\error\ApiEntityCouldNotBeMappedInPostRequest;
use taurus\framework\routing\Request;

class SaveEntityDefaultServiceImpl implements SaveEntityService
{
    /**
     * @var BaseRepository
     */
    private $baseRepository;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var EntityBuilder
     */
    private $entityBuilder;

    /**
     * SaveEntityDefaultServiceImpl constructor.
     * @param BaseRepository $baseRepository
     * @param EntityBuilder $entityBuilder
     */
    public function __construct(BaseRepository $baseRepository, EntityBuilder $entityBuilder)
    {
        $this->baseRepository = $baseRepository;
        $this->entityBuilder = $entityBuilder;
    }

    /**
     * @param Request $request
     * @throws ApiCouldNotSaveEntityException
     */
    public function saveEntity(Request $request)
    {
        $entity = $this->entityBuilder->convertOne(
            $this->getEntityDataFromRequest($request),
            $this->entityClass
        );

        if ($this->baseRepository->save($entity) === false) {
            throw new ApiCouldNotSaveEntityException($this->entityClass);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws ApiEntityCouldNotBeMappedInPostRequest
     */
    private function getEntityDataFromRequest(Request $request): array
    {
        $entityName = $this->getEntityClassName();
        if ($request->getParamByName($entityName) !== null) {
            if (is_array($request->getParamByName($entityName))) {
                return $request->getParamByName($entityName);
            }
        }

        throw new ApiEntityCouldNotBeMappedInPostRequest($entityName);
    }

    /**
     * @return string
     */
    private function getEntityClassName(): string
    {
        return strtolower(basename(str_replace('\\', '/', $this->entityClass)));
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 19:43
 */

namespace taurus\framework\api;


use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
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
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var RequestEntityMapper
     */
    private $requestEntityMapper;

    /**
     * SaveEntityDefaultServiceImpl constructor.
     * @param BaseRepository $baseRepository
     * @param DatabaseManager $databaseManager
     * @param RequestEntityMapper $requestEntityMapper
     */
    public function __construct(BaseRepository $baseRepository, DatabaseManager $databaseManager, RequestEntityMapper $requestEntityMapper)
    {
        $this->baseRepository = $baseRepository;
        $this->databaseManager = $databaseManager;
        $this->requestEntityMapper = $requestEntityMapper;
    }

    /**
     * @param Request $request
     * @throws ApiCouldNotSaveEntityException
     */
    public function saveEntity(Request $request)
    {
        $entity = $this->databaseManager->convertRequestToEntity(
            $this->requestEntityMapper->getEntityDataFromRequest($request, $this->entityClass),
            $this->entityClass
        );

        if ($this->baseRepository->save($entity) === false) {
            throw new ApiCouldNotSaveEntityException($this->entityClass);
        }
    }


    /**
     * @param string $entityClass
     * @return void
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
}

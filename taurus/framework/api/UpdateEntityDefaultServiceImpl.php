<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/03/17
 * Time: 19:47
 */

namespace taurus\framework\api;

use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\routing\Request;

class UpdateEntityDefaultServiceImpl implements UpdateEntityService
{
    /** @var BaseRepository */
    private $baseRepository;

    /** @var BaseRepository */
    private $databaseManager;

    /** @var RequestEntityMapper */
    private $requestEntityMapper;

    /** @var string */
    private $entityClass;

    /**
     * UpdateEntityDefaultServiceImpl constructor.
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
     * @return mixed
     */
    public function updateEntity(Request $request)
    {
        $entity = $this->databaseManager->convertRequestToEntity(
            $this->requestEntityMapper->getEntityDataFromRequest(
                $request,
                $this->entityClass
            ),
            $this->entityClass
        );

        if($request->getRequestParamByName('id')) {
            $entity->setId($request->getRequestParamByName('id'));
        }

        $this->baseRepository->update($entity);
    }

    /**
     * @param string $class
     * @return void
     */
    public function setEntityClass(string $class): void
    {
        $this->entityClass = $class;
    }
}

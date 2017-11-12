<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 19:51
 */

namespace taurus\framework\api;


use taurus\framework\config\TaurusConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\routing\Request;

class GetAllEntitiesDefaultServiceImpl implements GetAllEntitiesService
{
    /** @var BaseRepository */
    private $baseRepo;

    /** @var string */
    private $entityClass;

    public function __construct(BaseRepository $baseRepository, TaurusConfig $taurusConfig)
    {
        $this->baseRepo = $baseRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllEntities(Request $request): array
    {

        return $this->baseRepo->findAll(
            $this->entityClass,
            $request->getPage(),
            $request->getPageSize());
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
}

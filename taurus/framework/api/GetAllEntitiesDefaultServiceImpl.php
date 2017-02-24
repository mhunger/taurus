<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 19:51
 */

namespace taurus\framework\api;


use taurus\framework\db\entity\BaseRepository;

class GetAllEntitiesDefaultServiceImpl implements GetAllEntitiesService
{
    /** @var BaseRepository */
    private $baseRepo;

    /** @var string */
    private $entityClass;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepo = $baseRepository;
    }

    /**
     * @return array
     */
    public function getAllEntities(): array
    {
        return $this->baseRepo->findAll($this->entityClass);
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
}

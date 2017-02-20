<?php

namespace taurus\framework\api;

use taurus\framework\db\Entity;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\error\EntityClassNotSetException;
use taurus\framework\error\Http404NotFoundException;

class GetEntityByIdDefaultServiceImpl implements GetEntityByIdService
{
    /** @var BaseRepository */
    private $baseRepository;

    /** @var string */
    private $entityClass;

    /**
     * GetEntityByIdDefaultServiceImpl constructor.
     * @param BaseRepository $baseRepository
     */
    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * @param int $id
     * @return Entity
     * @throws EntityClassNotSetException
     * @throws Http404NotFoundException
     */
    function getEntityById(int $id): Entity
    {
        if (is_null($this->entityClass)) {
            throw new EntityClassNotSetException();
        }

        $result = $this->baseRepository->findOne($id, $this->entityClass);

        if ($result !== null) {
            return $result;
        } else {
            throw new Http404NotFoundException($id, $this->entityClass);
        }
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
}

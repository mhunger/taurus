<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:21
 */

namespace taurus\framework\api;


use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\query\SpecificationBuilder;
use taurus\framework\routing\Request;

class GetBySpecificationDefaultServiceImpl implements GetBySpecificationService
{
    /** @var string */
    private $entityClass;

    /** @var string */
    private $specificationClass;

    /** @var BaseRepository */
    private $baseRepository;

    /** @var SpecificationBuilder */
    private $specificiationBuilder;

    /**
     * GetBySpecificationDefaultServiceImpl constructor.
     * @param BaseRepository $baseRepository
     * @param SpecificationBuilder $specificiationBuilder
     */
    public function __construct(BaseRepository $baseRepository, SpecificationBuilder $specificiationBuilder)
    {
        $this->baseRepository = $baseRepository;
        $this->specificiationBuilder = $specificiationBuilder;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getResultByRequest(Request $request): array
    {
        $specification = $this->specificiationBuilder->build($request, $this->specificationClass);
        return $this->baseRepository->findBySpecification($specification, $this->entityClass);
    }

    /**
     * @param string $entityClass
     */
    public function setSpecificationClass(string $entityClass): void
    {
        $this->specificationClass = $entityClass;
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
}

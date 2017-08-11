<?php
namespace bin\generator;

use const DIRECTORY_SEPARATOR;
use function dirname;
use function getcwd;
use taurus\framework\db\entity\EntityMetaDataWrapper;
use bin\tpl\TemplateRenderer;

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 20/07/17
 * Time: 10:58
 */
class TaurusGenerator
{
    /** @var EntityMetaDataWrapper */
    private $entityMetaData;

    /**
     * TaurusGenerator constructor.
     * @param EntityMetaDataWrapper $entityMetaData
     */
    public function __construct(EntityMetaDataWrapper $entityMetaData)
    {
        $this->entityMetaData = $entityMetaData;
    }

    /**
     * @param string $entityClass
     */
    public function generateEntity(string $entityClass)
    {
        $jsonTypes = $this->entityMetaData->getJsonTypes($entityClass);

        $tpl = new TemplateRenderer('generator/js/entity.ts.tpl');
    }
}
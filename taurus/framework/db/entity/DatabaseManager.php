<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:52
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\InputProcessor;
use taurus\framework\annotation\OneToMany;
use taurus\framework\annotation\OneToOne;
use taurus\framework\annotation\PasswordHash;
use taurus\framework\db\DbConnection;
use taurus\framework\db\Entity;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\query\UpdateQuery;
use taurus\framework\routing\Request;

/**
 * Class DatabaseManager
 * @package taurus\framework\db\entity
 */
class DatabaseManager implements EntityAccessLayer
{

    /** @var DbConnection */
    private $dbConnection;

    /** @var EntityBuilder */
    private $entityBuilder;

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /** @var OneToOneBuilder */
    private $oneToOneBuilder;

    /** @var OneToManyBuilder */
    private $oneToManyBuilder;

    /**
     * DatabaseManager constructor.
     * @param DbConnection $dbConnection
     * @param EntityBuilder $entityBuilder
     * @param EntityMetaDataImpl $entityMetaDataImpl
     * @param OneToOneBuilder $oneToOneBuilder
     * @param OneToManyBuilder $oneToManyBuilder
     */
    function __construct(
        DbConnection $dbConnection,
        EntityBuilder $entityBuilder,
        EntityMetaDataImpl $entityMetaDataImpl,
        OneToOneBuilder $oneToOneBuilder,
        OneToManyBuilder $oneToManyBuilder
    ) {
        $this->dbConnection = $dbConnection;
        $this->entityBuilder = $entityBuilder;
        $this->entityMetaDataImpl = $entityMetaDataImpl;
        $this->oneToOneBuilder = $oneToOneBuilder;
        $this->oneToManyBuilder = $oneToManyBuilder;
    }

    /**
     * @param UpdateQuery $updateQuery
     * @return bool|mixed|\mysqli_result
     */
    public function update(UpdateQuery $updateQuery)
    {
        return $this->dbConnection->update($updateQuery);
    }

    /**
     * @param DeleteQuery $deleteQuery
     * @return bool|mixed|\mysqli_result
     */
    public function delete(DeleteQuery $deleteQuery)
    {
        return $this->dbConnection->delete($deleteQuery);
    }

    /**
     * @param Query $query
     * @param null $class
     * @param array $loadedDependencies
     * @return array
     */
    public function fetchMany(Query $query, $class, array $loadedDependencies = null): array
    {
        $result = $this->dbConnection->executeMany($query);

        $entities = [];
        foreach ($result as $row) {
            $relationshipData = $this->fetchDependenciesForClass(
                $class,
                $row,
                $row[$this->entityMetaDataImpl->getIdField($class)],
                $loadedDependencies
            );

            $entities[] = $this->entityBuilder->convertOne($row, $class, $relationshipData);
        }

        return $entities;
    }

    /**
     * @param Query $query
     * @param string $class
     * @param int $id
     * @param array $loadedDependencies
     * @return null|Entity
     */
    public function fetchOne(Query $query, string $class, int $id, array $loadedDependencies = null)
    {
        $result = $this->dbConnection->executeOne($query);

        if (is_null($result) || count($result) == 0) {
            return null;
        }

        $relationshipData = $this->fetchDependenciesForClass($class, $result, $id, $loadedDependencies);

        return $this->entityBuilder->convertOne($result, $class, $relationshipData);
    }

    /**
     * @param string $class
     * @param array $result
     * @param int $id
     * @param array $loadedDependencies
     * @return array
     */
    private function fetchDependenciesForClass(
        string $class,
        array $result,
        int $id = null,
        array $loadedDependencies = null
    ): array {
        $rels = $this->entityMetaDataImpl->getRelationships($class);

        /**
         * If the class dependencies were already loaded before, because of circular reference, then don't load it again to
         * prevent endless loop
         */
        if ($loadedDependencies !== null && in_array($class, $loadedDependencies)) {
            return $this->fetchEmptyDependencyData($class, $rels);
        } else {
            return $this->fetchDependencyDataForClass($class, $result, $rels, $loadedDependencies);
        }
    }

    /**
     * @param string $class
     * @param array $result
     * @param array $rels
     * @param array|null $loadedDependencies
     * @return array
     */
    private function fetchDependencyDataForClass(
        string $class,
        array $result,
        array $rels,
        array $loadedDependencies = null
    ): array {
        $dependencies = [];

        /**
         * @var string $property
         * @var OneToOne|OneToMany $annotation
         */
        foreach ($rels as $property => $annotation) {
            switch (get_class($annotation)) {
                case OneToOne::class:
                    $dependencies[$annotation->getColumn()] =
                        $this->fetchOne(
                            $this->oneToOneBuilder->build($annotation, $result[$annotation->getColumn()]),
                            $annotation->getEntity(),
                            $result[$annotation->getColumn()],
                            $this->updateLoadedDependencies($loadedDependencies, $class)
                        );

                    break;
                case OneToMany::class:
                    $dependencies[$annotation->getProperty()] =
                        $this->fetchMany(
                            $this->oneToManyBuilder->build($annotation,
                                $result[$this->entityMetaDataImpl->getIdField($class)]),
                            $annotation->getEntity(),
                            $this->updateLoadedDependencies($loadedDependencies, $class)
                        );
                    break;
            }
        }

        return $dependencies;
    }


    /**
     * If the dependency was already loaded in a previous level of the tree, then we have to set it, but empty.
     * This should later become an empty entities with only id set and transformed into special subclass telling
     * it is cut off
     *
     * @param string $class
     * @param array $rels
     * @return array
     */
    private function fetchEmptyDependencyData(string $class, array $rels): array
    {
        $dependencies = [];
        /**
         * @var string $property
         * @var  OneToMany|OneToOne $annotation
         */
        foreach ($rels as $property => $annotation) {

            switch($annotation->getAnnotationName()) {
                case OneToMany::ANNOTATION_NAME_ONETOMANY:
                    $dependencies[$annotation->getProperty()] = [];
                    break;
                case OneToOne::ANNOTATION_NAME_ONETOONE:
                    $reflectionClass = new \ReflectionClass($annotation->getEntity());
                    $instance = $reflectionClass->newInstance();
                    $dependencies[$annotation->getColumn()] = $instance;
                    break;
            }
        }

        return $dependencies;
    }

    /**
     * @param array|null $loadedDependencies
     * @param string $class
     * @return array
     */
    private function updateLoadedDependencies(array $loadedDependencies = null, string $class): array
    {
        if ($loadedDependencies === null) {
            $loadedDependencies = [];
        }

        $loadedDependencies[] = $class;

        return $loadedDependencies;
    }

    /**
     * @param InsertQuery $query
     * @return bool
     */
    public function insert(InsertQuery $query): bool
    {
        return $this->dbConnection->insert($query);
    }

    /**
     * @param array $requestInput
     * @param string $class
     * @return Entity
     */
    public function convertRequestToEntity(array $requestInput, string $class): Entity
    {
        $input = $this->mapRequestInputPropertyNamesToColumnNames($requestInput, $class);
        $rels = $this->fetchDependenciesForClass(
            $class,
            $input

        );

        return $this->entityBuilder->convertOne($input, $class, $rels);

    }

    /**
     * Maps incoming request property name of the entity to database name as incoming data is using
     * entity names / property names, while internals work on persistence layer names.
     *
     * @param array $requestInput
     * @param string $class
     * @return array
     */
    public function mapRequestInputPropertyNamesToColumnNames(array $requestInput, string $class): array
    {
        $columnMap = $this->entityMetaDataImpl->getColumnMap($class, true);

        $input = [];
        foreach ($requestInput as $propertyName => $value) {
            $input[$columnMap[$propertyName]] = $this->processInputData($class, $columnMap[$propertyName], $value);
        }
        return $input;
    }

    /**
     * @param string $class
     * @param string $propertyName
     * @param $value
     * @return bool|string
     */
    private function processInputData(string $class, string $propertyName, $value)
    {
        /** @var PasswordHash $passwordHashAnnotation */
        $passwordHashAnnotation = $this->entityMetaDataImpl->getInputProcessors($class, $propertyName);

        if($passwordHashAnnotation !== null && $passwordHashAnnotation instanceof InputProcessor) {
            return $passwordHashAnnotation->apply($value);
        }

        return $value;
    }
}

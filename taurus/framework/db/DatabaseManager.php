<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:52
 */

namespace taurus\framework\db;

use fitnessmanager\workout\Workout;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\mysql\MySqlConnection;

class DatabaseManager {

    /** @var MysqlConnection */
    private $dbConnection;

    /** @var EntityBuilder */
    private $entityBuilder;

    /** @var BaseRepository */
    private $baseRepository;

    /**
     * @param DbConnection $dbConnection
     * @param EntityBuilder $entityBuilder
     * @param BaseRepository $baseRepository
     */
    public function __construct(DbConnection $dbConnection, EntityBuilder $entityBuilder, BaseRepository $baseRepository) {
        $this->dbConnection = $dbConnection;
        $this->entityBuilder = $entityBuilder;
        $this->baseRepository = $baseRepository;
    }

    /**
     * Fetches all objects from the entityClass
     *
     * @param $entityClass
     * @return array
     */
    public function findAll($entityClass) {
        return $this->dbConnection->fetchObjects('select * from workout', Workout::class);
    }
}

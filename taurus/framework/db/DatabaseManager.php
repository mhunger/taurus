<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:52
 */

namespace taurus\framework\db;

class DatabaseManager {

    /** @var MysqlConnection */
    private $dbConnection;

    /** @var EntityBuilder */
    private $entityBuilder;

    /** @var BaseRepository */
    private $baseRepository;

    /**
     * @param MySqlConnection $dbConnection
     * @param EntityBuilder $entityBuilder
     * @param BaseRepository $baseRepository
     */
    public function __construct(MySqlConnection $dbConnection, EntityBuilder $entityBuilder, BaseRepository $baseRepository) {
        $this->dbConnection = $dbConnection;
        $this->entityBuilder = $entityBuilder;
        $this->baseRepository = $baseRepository;
    }
}

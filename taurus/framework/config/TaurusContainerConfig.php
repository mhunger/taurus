<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:58
 */

namespace taurus\framework\config;

use bin\generator\TaurusGenerator;
use bin\tpl\TaurusInitiator;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\api\AuthenticationController;
use taurus\framework\api\AuthenticationHandlerDefaultServiceImpl;
use taurus\framework\api\GetAllEntitiesApiController;
use taurus\framework\api\GetAllEntitiesDefaultServiceImpl;
use taurus\framework\api\GetByIdApiController;
use taurus\framework\api\GetBySpecificationApiController;
use taurus\framework\api\GetBySpecificationDefaultServiceImpl;
use taurus\framework\api\GetEntityByIdDefaultServiceImpl;
use taurus\framework\api\SaveEntityApiController;
use taurus\framework\api\SaveEntityDefaultServiceImpl;
use taurus\framework\api\UpdateEntityApiController;
use taurus\framework\api\UpdateEntityDefaultServiceImpl;
use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\mysql\MySqlConnection;
use taurus\framework\db\mysql\MySqlDeleteQueryStringBuilder;
use taurus\framework\db\mysql\MysqlInsertQueryStringBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;
use taurus\framework\db\mysql\MysqlSelectQueryStringBuilder;
use taurus\framework\db\mysql\MySqlUpdateQueryStringBuilder;
use taurus\framework\db\query\expression\ExpressionBuilder;
use taurus\framework\db\query\SpecificationBuilder;
use taurus\framework\Environment;
use taurus\framework\mock\MockRequest;
use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\framework\routing\TaurusTestRouteConfig;
use taurus\framework\routing\Router;
use taurus\framework\util\MysqlUtils;
use taurus\framework\security\AuthenticationService;
use taurus\framework\security\StandardTokenAuthenticationServiceImpl;
use taurus\framework\security\StandardTokenImpl;
use taurus\tests\fixtures\ExerciseBuilder;

/**
 * Standard taurus container config contains all the services used inside taurus
 *
 * Class TaurusContainerConfig
 * @package taurus\framework\container
 */
class TaurusContainerConfig extends AbstractContainerConfig {

    const SERVICE_ROUTE_CONFIG = TaurusTestRouteConfig::class;
    const SERVICE_REQUEST = Request::class;
    const SERVICE_MOCK_SERVER = MockServer::class;
    const SERVICE_MYSQL_CONNECTION = MySqlConnection::class;
    const SERVICE_DB_MANAGER = DatabaseManager::class;
    const SERVICE_ROUTER = Router::class;
    const SERVICE_ENVIRONMENT = Environment::class;
    const SERVICE_ANNOTATION_READER = AnnotationReader::class;
    const SERVICE_BASE_REPOSITORY = BaseRepository::class;
    const SERVICE_ENTITY_METADATA = EntityMetaDataImpl::class;
    const SERVICE_ENTITY_METADATA_STORE = EntityMetaDataStore::class;
    const SERVICE_MYSQL_QUERY_STRING_BUILDER = MySqlQueryStringBuilderImpl::class;
    const SERVICE_ENTITY_BUILDER = EntityBuilder::class;
    const SERVICE_DEFAULT_GETBYID_CONTROLLER = GetByIdApiController::class;
    const SERVICE_DEFAULT_GETBYID_SERVICE = GetEntityByIdDefaultServiceImpl::class;
    const SERVICE_DEFAULT_SAVE_ENTITY_SERVICE = SaveEntityDefaultServiceImpl::class;
    const SERVICE_DEFAULT_SAVE_ENTITY_CONTROLLER = SaveEntityApiController::class;
    const SERVICE_DEFAULT_GET_ALL_ENTITIES_SERVICE = GetAllEntitiesDefaultServiceImpl::class;
    const SERVICE_DEFAULT_GET_ALL_ENTITIES_CONTROLLER = GetAllEntitiesApiController::class;
    const SERVICE_DEFAULT_PUT_ENTITY_SERVICE = UpdateEntityDefaultServiceImpl::class;
    const SERVICE_DEFAULT_PUT_ENTITY_CONTROLLER = UpdateEntityApiController::class;
    const SERVICE_EXERCISE_BUILDER = ExerciseBuilder::class;
    const SERVICE_DEFAULT_GETBYSPEC_CONTROLLER = GetBySpecificationApiController::class;
    const SERVICE_DEFAULT_GETBYSPEC_DEFAULT_SERVICE = GetBySpecificationDefaultServiceImpl::class;
    const SERVICE_EXPRESSION_BUILDER = ExpressionBuilder::class;
    const SERVICE_SPECIFICATION_BUILDER = SpecificationBuilder::class;
    const SERVICE_MOCK_REQUEST = MockRequest::class;
    const SERVICE_STANDARD_AUTHENTICATION_SERVICE = StandardTokenAuthenticationServiceImpl::class;
    const SERVICE_AUTHENTICATION_TOKEN = StandardTokenImpl::class;
    const SERVICE_AUTH_CONTROLLER = AuthenticationController::class;
    const SERVICE_AUTH_HANDLER_DEFAULT_SERVICE = AuthenticationHandlerDefaultServiceImpl::class;
    const SERVICE_MYSQL_UTILS = MysqlUtils::class;
    const SERVICE_TAURUS_GENERATOR = TaurusGenerator::class;
    const SERVICE_TAURUS_INITIALISER = TaurusInitiator::class;
    const SERVICE_TAURUS_CONFIG = TaurusConfig::class;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    protected function configure()
    {
        $this->serviceDefinitions[self::SERVICE_ROUTE_CONFIG] =
            new ServiceConfig(self::SERVICE_ROUTE_CONFIG,
                null,
                [TaurusTestRouteConfig::API_BASE_PATH],
                true
            );

        $this->serviceDefinitions[self::SERVICE_DB_MANAGER] =
            new ServiceConfig(self::SERVICE_DB_MANAGER,
                'dbManager',
                [
                    MySqlConnection::class
                ],
                true
            );

        $this->serviceDefinitions[self::SERVICE_BASE_REPOSITORY] =
            new ServiceConfig(self::SERVICE_BASE_REPOSITORY,
                'BaseRepository',
                [null, EntityMetaDataImpl::class, DatabaseManager::class]
            );

        $this->serviceDefinitions[self::SERVICE_ENVIRONMENT] =
            new ServiceConfig(self::SERVICE_ENVIRONMENT,
                'environment',
                [Environment::PROD],
                true
            );


        $this->serviceDefinitions[self::SERVICE_MYSQL_QUERY_STRING_BUILDER] =
            new ServiceConfig(self::SERVICE_MYSQL_QUERY_STRING_BUILDER,
                'mysqlQueryStringBuilder',
                [
                    MysqlSelectQueryStringBuilder::class,
                    MysqlInsertQueryStringBuilder::class,
                    MySqlDeleteQueryStringBuilder::class,
                    MySqlUpdateQueryStringBuilder::class
                ]);

        $this->serviceDefinitions[self::SERVICE_ENTITY_BUILDER] =
            new ServiceConfig(self::SERVICE_ENTITY_BUILDER,
                'entityBuilder',
                [
                    EntityMetaDataImpl::class
                ]);

        $this->serviceDefinitions[self::SERVICE_TAURUS_GENERATOR] =
            new ServiceConfig(self::SERVICE_TAURUS_GENERATOR,
                'taurusGenerator',
                [
                    self::SERVICE_ENTITY_METADATA
                ],
                true);

        $this->serviceDefinitions[self::SERVICE_AUTHENTICATION_TOKEN] =
            new ServiceConfig(self::SERVICE_AUTHENTICATION_TOKEN,
                'auth_token',
                null,
                true
            );
        $this->serviceDefinitions[self::SERVICE_AUTH_HANDLER_DEFAULT_SERVICE] =
            new ServiceConfig(self::SERVICE_AUTH_HANDLER_DEFAULT_SERVICE,
                'default_auth_handler_service',
                [
                    StandardTokenImpl::class
                ]);

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ROUTER] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ROUTER,
                'router',
                [
                    TaurusTestRouteConfig::class,
                    null,
                    StandardTokenAuthenticationServiceImpl::class,
                    StandardTokenImpl::class
                ]);

        $this->serviceDefinitions[self::SERVICE_STANDARD_AUTHENTICATION_SERVICE] =
            new ServiceConfig(self::SERVICE_STANDARD_AUTHENTICATION_SERVICE,
                'standard_auth_service',
                [
                    null,
                    StandardTokenImpl::class
                ]);

        $this->serviceDefinitions[self::SERVICE_TAURUS_CONFIG] =
            new ServiceConfig(self::SERVICE_TAURUS_CONFIG,
                'taurus_config',
                [],
                true
            );
    }
}

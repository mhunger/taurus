<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 19:57
 */

namespace taurus\tests\db\mysql;


use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;

use taurus\framework\db\query\QueryBuilder;
use taurus\tests\AbstractTaurusTest;

class MySqlDeleteQueryStringBuilderTest extends AbstractTaurusTest
{
    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var MySqlQueryStringBuilderImpl */
    private $mysqlQueryStringbuilder;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        /** @var MySqlQueryStringBuilderImpl $mysqlQueryStringbuilder */
        $this->mysqlQueryStringbuilder = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_MYSQL_QUERY_STRING_BUILDER);

        /** @var QueryBuilder $queryBuilder */
        $this->queryBuilder = Container::getInstance()->getService(QueryBuilder::class);
    }

    public function testParseDeleteQueryWithSingleId()
    {

        $expectedQuery = 'DELETE FROM `test_table` WHERE `id` = 1';

        $this->assertEquals(
            $expectedQuery,
            $this->mysqlQueryStringbuilder->getDeleteQueryString(
                $this->queryBuilder->query(QueryBuilder::QUERY_TYPE_DELETE)
                    ->deleteFrom('test_table')
                    ->where('id', [1])
            ),
            'Delete Query did not match'
        );
    }

    public function testParseDeleteQueryWithMultipleIds()
    {
        $expectedQuery = 'DELETE FROM `test_table` WHERE `id` IN (1, 2)';

        $this->assertEquals(
            $expectedQuery,
            $this->mysqlQueryStringbuilder->getDeleteQueryString(
                $this->queryBuilder->query(QueryBuilder::QUERY_TYPE_DELETE)
                    ->deleteFrom('test_table')
                    ->where('id', [1, 2])
            ),
            'Delete Query did not match'
        );
    }
}
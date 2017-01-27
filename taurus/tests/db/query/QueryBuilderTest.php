<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:28
 */

namespace taurus\tests\db\query;


use PHPUnit\Framework\TestCase;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilder;

class QueryBuilderTest extends TestCase
{

    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var MySqlQueryStringBuilder */
    private $mysqlQueryStringBuilder;

    protected function setUp()
    {
        parent::setUp();
        $this->queryBuilder = new QueryBuilder();
        $this->mysqlQueryStringBuilder = new MySqlQueryStringBuilder();
    }


    public function testSimpleQueryWithNoFieldsAndDb()
    {
        $query = $this->queryBuilder
            ->query()
            ->select()
            ->from('workout');

        $this->assertEquals(
            'SELECT * FROM workout',
            $this->mysqlQueryStringBuilder->getQueryString($query),
            "Query Builder has not parsed correct query for simple query without fields"
        );
    }
}
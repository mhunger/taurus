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

    public function testSimpleQueryWithFieldsAndDb()
    {
        $this->assertEquals(
            'SELECT id, date FROM fitnessmanager.workout',
            $this->mysqlQueryStringBuilder
                ->getQueryString(
                    $this->queryBuilder
                        ->query()
                        ->select(['id', 'date'])
                        ->from('workout', 'fitnessmanager')
                )
        );
    }

    public function testQueryWithSimpleWhereClause() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE id = 1',
            $this->mysqlQueryStringBuilder->getQueryString(
                $this->queryBuilder
                ->query()
                ->select()
                ->from('workout')
                ->where('id')
                    ->isEqualTo(1)
            ),
            "Could not generate query with single where clause"
        );
    }

    public function testQueryWithMultipleAndConditions() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE id = 1 AND date = 2017-01-01',
            $this->mysqlQueryStringBuilder
            ->getQueryString(
                $this->queryBuilder->query()
                ->select()
                ->from('workout')
                ->where('id')
                ->isEqualTo(1)
                ->andWhere('date')
                ->isEqualTo('2017-01-01')
            ),
            "Cannot create query with multiple and expressions"
        );
    }
}
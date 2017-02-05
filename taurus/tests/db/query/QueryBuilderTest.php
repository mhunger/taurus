<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:28
 */

namespace taurus\tests\db\query;


use PHPUnit\Framework\TestCase;
use taurus\framework\db\mysql\MysqlInsertQueryStringBuilder;
use taurus\framework\db\mysql\MysqlSelectQueryStringBuilder;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;

class QueryBuilderTest extends TestCase
{

    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var MySqlQueryStringBuilderImpl */
    private $mysqlQueryStringBuilder;

    protected function setUp()
    {
        parent::setUp();
        $this->queryBuilder = new QueryBuilder();
        $this->mysqlQueryStringBuilder = new MySqlQueryStringBuilderImpl(
            new MysqlSelectQueryStringBuilder(),
            new MysqlInsertQueryStringBuilder()
        );
    }


    public function testSimpleQueryWithNoFieldsAndDb()
    {
        $query = $this->queryBuilder
            ->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from('workout');

        $this->assertEquals(
            'SELECT * FROM workout',
            $this->mysqlQueryStringBuilder->getSelectQueryString($query),
            "Query Builder has not parsed correct query for simple query without fields"
        );
    }

    public function testSimpleQueryWithFieldsAndDb()
    {
        $this->assertEquals(
            'SELECT id, date FROM fitnessmanager.workout',
            $this->mysqlQueryStringBuilder
                ->getSelectQueryString(
                    $this->queryBuilder
                        ->query(QueryBuilder::QUERY_TYPE_SELECT)
                        ->select(['id', 'date'])
                        ->from('workout', 'fitnessmanager')
                )
        );
    }

    public function testQueryWithSimpleWhereClause() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE id = 1',
            $this->mysqlQueryStringBuilder->getSelectQueryString(
                $this->queryBuilder
                    ->query(QueryBuilder::QUERY_TYPE_SELECT)
                ->select()
                ->from('workout')
                    ->where(
                        new ComparisonExpression(
                            new Field('id'),
                            new Equals(),
                            new Literal(1)
                        )
                    )
            ),
            "Could not generate query with single where clause"
        );
    }

    public function testQueryWithMultipleAndConditions() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE id = 1 AND date = \'2016-01-01\'',
            $this->mysqlQueryStringBuilder->getSelectQueryString(
                $this->queryBuilder
                    ->query(QueryBuilder::QUERY_TYPE_SELECT)
                    ->select()
                    ->from('workout')
                    ->where(
                        new ConditionalExpression(
                            new ComparisonExpression(
                                new Field('id'),
                                new Equals(),
                                new Literal(1)
                            ),
                            new AndOperation(),
                            new ComparisonExpression(
                                new Field('date'),
                                new Equals(),
                                new Literal('2016-01-01')
                            )
                        )
                    )
            ),
            "Could not generate query with single where clause"
        );
    }
}
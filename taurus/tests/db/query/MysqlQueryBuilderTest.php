<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:28
 */

namespace taurus\tests\db\query;


use taurus\framework\annotation\Spec;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;


use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\operation\GreaterThan;
use taurus\framework\db\query\operation\SmallerThanEquals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;
use taurus\framework\db\query\SelectField;
use taurus\framework\db\query\SelectItemFunction;
use taurus\tests\AbstractTaurusTest;

class MysqlQueryBuilderTest extends AbstractTaurusTest
{

    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var MySqlQueryStringBuilderImpl */
    private $mysqlQueryStringBuilder;

    protected function setUp()
    {
        parent::setUp();
        $this->queryBuilder = new QueryBuilder();
        $this->mysqlQueryStringBuilder = Container::getInstance()
            ->getService(TaurusContainerConfig::SERVICE_MYSQL_QUERY_STRING_BUILDER);
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
            'SELECT `fitnessmanager`.`workout`.`id`, `fitnessmanager`.`workout`.`date` FROM `fitnessmanager`.`workout`',
            $this->mysqlQueryStringBuilder
                ->getSelectQueryString(
                    $this->queryBuilder
                        ->query(QueryBuilder::QUERY_TYPE_SELECT)
                        ->select([
                                new SelectField(null, 'id'),
                                new SelectField(null, 'date')]
                        )
                        ->from('workout', 'fitnessmanager')
                )
        );
    }

    public function testQueryWithSimpleWhereClause() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE `id` = 1',
            $this->mysqlQueryStringBuilder->getSelectQueryString(
                $this->queryBuilder
                    ->query(QueryBuilder::QUERY_TYPE_SELECT)
                ->select()
                ->from('workout')
                    ->where(
                        new ComparisonExpression(
                            new Field('id'),
                            new Equals(),
                            new Literal(1, Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER)
                        )
                    )
            ),
            "Could not generate query with single where clause"
        );
    }

    public function testQueryWithMultipleAndConditions() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE `id` = 1 AND `date` = \'2016-01-01\'',
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
                                new Literal(1, Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER)
                            ),
                            new AndOperation(),
                            new ComparisonExpression(
                                new Field('date'),
                                new Equals(),
                                new Literal('2016-01-01', Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING)
                            )
                        )
                    )
            ),
            "Could not generate query with single where clause"
        );
    }

    public function testQueryWithMultipleAndConditionsAndOperations() {
        $this->assertEquals(
            'SELECT * FROM workout WHERE `id` > 1 AND `date` <= \'2016-01-01\'',
            $this->mysqlQueryStringBuilder->getSelectQueryString(
                $this->queryBuilder
                    ->query(QueryBuilder::QUERY_TYPE_SELECT)
                    ->select()
                    ->from('workout')
                    ->where(
                        new ConditionalExpression(
                            new ComparisonExpression(
                                new Field('id'),
                                new GreaterThan(),
                                new Literal(1, Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER)
                            ),
                            new AndOperation(),
                            new ComparisonExpression(
                                new Field('date'),
                                new SmallerThanEquals(),
                                new Literal('2016-01-01', Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING)
                            )
                        )
                    )
            ),
            "Could not generate query with single where clause"
        );
    }

    public function testInsertQuery()
    {
        $this->assertEquals(
            'INSERT INTO `exercise` (`exercise_id`, `name`, `difficulty`, `variant_name`) VALUES (null, \'Push-Ups\', \'medium\', \'Standing\')',
            $this->mysqlQueryStringBuilder->getInsertQueryString(
                $this->queryBuilder->query(QueryBuilder::QUERY_TYPE_INSERT)
                    ->insertInto(
                        'exercise', [
                        'exercise_id',
                        'name',
                        'difficulty',
                        'variant_name'
                    ])
                    ->values([null, 'Push-Ups', 'medium', 'Standing'])
            ),
            'Did not get correct insert query string for exercise table'
        );
    }

    public function testDeleteQueryCreated()
    {
        $this->assertInstanceOf(
            DeleteQuery::class,
            $this->queryBuilder->query(QueryBuilder::QUERY_TYPE_DELETE),
            'Delete query not created. Instance type is wrong'
        );
    }

    public function testSimpleJoin()
    {
        $this->assertEquals(
            'SELECT `fitnessmanager`.`workout`.`id`, `fitnessmanager`.`workout`.`date` FROM `fitnessmanager`.`workout` LEFT JOIN `workout_location` ON `workout_location`.`id` = `workout`.`workout_location_id`',
            $this->mysqlQueryStringBuilder
                ->getSelectQueryString(
                    $this->queryBuilder
                        ->query(QueryBuilder::QUERY_TYPE_SELECT)
                        ->select([new SelectField(null, 'id'),
                            new SelectField(null, 'date')])
                        ->from('workout', 'fitnessmanager')
                        ->join('workout_location', null, 'id', 'workout_location_id')
                )
        );
    }

    public function testDateAddFunctionInSelect()
    {
        $this->assertEquals(
            'SELECT ADDDATE(date, INTERVAL 31 DAY) AS newDate, `fitnessmanager`.`workout`.`id`, `fitnessmanager`.`workout`.`date` FROM `fitnessmanager`.`workout` LEFT JOIN `workout_location` ON `workout_location`.`id` = `workout`.`workout_location_id`',
            $this->mysqlQueryStringBuilder
                ->getSelectQueryString(
                    $this->queryBuilder
                        ->query(QueryBuilder::QUERY_TYPE_SELECT)
                        ->select([new SelectItemFunction('ADDDATE', 'newDate', ['date', 'INTERVAL 31 DAY']),
                            new SelectField(null, 'id'),
                            new SelectField(null, 'date')])
                        ->from('workout', 'fitnessmanager')
                        ->join('workout_location', null, 'id', 'workout_location_id')
                )
        );
    }
}

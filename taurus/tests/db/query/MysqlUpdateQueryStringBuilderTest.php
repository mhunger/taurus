<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 23:09
 */

namespace taurus\tests\db\query;


use taurus\framework\Container;
use taurus\framework\db\mysql\MySqlUpdateQueryStringBuilder;
use taurus\framework\db\query\QueryBuilder;

use taurus\tests\AbstractTaurusTest;

class MysqlUpdateQueryStringBuilderTest extends AbstractTaurusTest
{

    /** @var MySqlUpdateQueryStringBuilder */
    private $subject;

    /** @var QueryBuilder */
    private $qb;

    public function setUp()
    {
        parent::setUp();
        $this->subject = new MySqlUpdateQueryStringBuilder();
        $this->qb = Container::getInstance()->getService(QueryBuilder::class);
    }

    public function testSimpleUpdateQuery()
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_UPDATE)
            ->update('test_table')
            ->set(
                [
                    'test_field' => 1,
                    'test_field2' => '2017-01-01'
                ]
            )->where('id', 1);

        $actualSql = $this->subject->getUpdateQueryString($q);
        $expectedSql = "UPDATE test_table SET test_field = 1, test_field2 = '2017-01-01' WHERE id = 1";

        $this->assertEquals(
            $expectedSql,
            $actualSql,
            'Did not build update query string correctly'
        );
    }
}

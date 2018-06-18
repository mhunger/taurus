<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/18
 * Time: 21:13
 */

namespace taurus\tests\db\query;


use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\query\SelectField;
use taurus\framework\db\query\SelectFieldsBuilder;
use taurus\framework\db\query\SelectItemFunction;
use taurus\tests\AbstractTaurusTest;
use taurus\tests\fixtures\TestEntity;

class SelectFieldBuilderTest extends AbstractTaurusTest
{

    /** @var SelectFieldsBuilder */
    private $selectFieldBuilder;

    protected function setUp()
    {
        parent::setUp();
        $this->selectFieldBuilder = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_SELECT_FIELD_BUILDER);
    }

    public function testBuild()
    {
        $expectedResult = [
            new SelectField('test_table', 'test_id', 'test_id'),
            new SelectField('test_table', 'password', 'password'),
            new SelectItemFunction('st_astext', 'geo_location', ['geo_location']),
            new SelectField('test_table', 'test_field', 'test_field')
        ];
        $actualResult = $this->selectFieldBuilder->build(TestEntity::class);

        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'Did not build select field list correctly'
        );
    }
}

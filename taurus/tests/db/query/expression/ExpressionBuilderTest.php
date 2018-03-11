<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 19:24
 */

namespace taurus\tests\db\query\expression;


use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\ExpressionBuilder;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\tests\AbstractTaurusTest;
use taurus\tests\fixtures\TestSpecification;
use taurus\tests\fixtures\TestSpecificationEven;

class ExpressionBuilderTest extends AbstractTaurusTest
{
    /** @var ExpressionBuilder */
    private $expressionBuilder;

    public function setUp()
    {
        parent::setUp();
        $this->expressionBuilder = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_EXPRESSION_BUILDER);
    }

    public function testBuildExpression()
    {
        $testSpec = new TestSpecification(
            'test',
            1,
            'test2'
        );

        $expectedExpression = new ConditionalExpression(
            new ComparisonExpression(
                new Field('spec_3'),
                new Equals(),
                new Literal('test2')
            ),
            new AndOperation(),
            new ConditionalExpression(
                new ComparisonExpression(
                    new Field('spec_1'),
                    new Equals(),
                    new Literal('test')
                ),
                new AndOperation(),
                new ComparisonExpression(
                    new Field('spec_2'),
                    new Equals(),
                    new Literal(1)
                )
            )
        );

        $this->assertEquals(
            $expectedExpression,
            $this->expressionBuilder->build($testSpec),
            'Did not build correct expresion out of test expression'
        );
    }

    public function testBuildExpressionEven()
    {
        $testSpec = new TestSpecificationEven(
            'test',
            1,
            'test2',
            4
        );

        $expectedExpresion = new ConditionalExpression(
            new ConditionalExpression(
                new ComparisonExpression(
                    new Field('spec_1'),
                    new Equals(),
                    new Literal('test')
                ),
                new AndOperation(),
                new ComparisonExpression(
                    new Field('spec_2'),
                    new Equals(),
                    new Literal(1)
                )
            ),
            new AndOperation(),
            new ConditionalExpression(
                new ComparisonExpression(
                    new Field('spec_3'),
                    new Equals(),
                    new Literal('test2')
                ),
                new AndOperation(),
                new ComparisonExpression(
                    new Field('spec_4'),
                    new Equals(),
                    new Literal(4)
                )
            )
        );

        $this->assertEquals(
            $expectedExpresion,
            $this->expressionBuilder->build($testSpec),
            'Did not build correct expresion out of test expression'
        );
    }
}

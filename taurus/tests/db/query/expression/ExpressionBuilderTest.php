<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 19:24
 */

namespace taurus\tests\db\query\expression;


use taurus\framework\annotation\Having;
use taurus\framework\annotation\Spec;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\ExpressionBuilder;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\operation\GreaterThan;
use taurus\framework\db\query\operation\GreaterThanEquals;
use taurus\framework\db\query\operation\Like;
use taurus\framework\db\query\operation\SmallerThan;
use taurus\framework\db\query\operation\SmallerThanEquals;
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
            'test2',
            'POINT(48.148641, 11.544918)',
            50000
        );

        $expectedExpression = new ConditionalExpression(
            new ComparisonExpression(
                new Field('spec_3'),
                new GreaterThanEquals(),
                new Literal('test2', Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThanEquals)
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
                    new SmallerThanEquals(),
                    new Literal(1, Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThanEquals)
                )
            )
        );

        $this->assertEquals(
            $expectedExpression,
            $this->expressionBuilder->build($testSpec),
            'Did not build correct expresion out of test expression'
        );
    }

    public function testBuildExpressionHaving()
    {
        $testSpec = new TestSpecification(
            'test',
            1,
            'test2',
            'POINT(48.148641, 11.544918)',
            50000
        );

        $expectedExpression = new ComparisonExpression(
            new Field('radius'),
            new SmallerThanEquals(),
            new Literal(50000, Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThanEquals, Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER)
        );

        $this->assertEquals(
            $expectedExpression,
            $this->expressionBuilder->build($testSpec, Having::ANNOTATION_NAME_HAVING),
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
                    new SmallerThan(),
                    new Literal(1, Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThan)
                )
            ),
            new AndOperation(),
            new ConditionalExpression(
                new ComparisonExpression(
                    new Field('spec_3'),
                    new GreaterThan(),
                    new Literal('test2', Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThan)
                ),
                new AndOperation(),
                new ComparisonExpression(
                    new Field('spec_4'),
                    new Like(),
                    new Literal(4, Spec::SPEC_ANNOTATION_FILTER_TYPE_LIKE)
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

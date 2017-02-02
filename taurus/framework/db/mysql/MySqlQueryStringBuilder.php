<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:23
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\expression\Expression;
use taurus\framework\db\query\expression\MultiPartExpression;
use taurus\framework\db\query\QueryStringBuilder;
use taurus\framework\db\query\SelectQuery;
use taurus\framework\db\query\Condition;
use taurus\framework\db\query\BooleanExpression;

class MySqlQueryStringBuilder implements QueryStringBuilder
{

    const MYSQL_SYNTAX_ALL_FIELDS = '*';

    const MYSQL_KEYWORD_SELECT = 'SELECT';

    const MYSQL_KEYWORD_FROM = 'FROM';

    const MYSQL_KEYWORD_WHERE = 'WHERE';

    /**
     * Return the mysql query string given a select query
     *
     * @param SelectQuery $selectQuery
     * @return string
     */
    public function getQueryString(SelectQuery $selectQuery)
    {
        $tokens = [];

        $tokens[] = self::MYSQL_KEYWORD_SELECT;
        $tokens[] = $this->getFields($selectQuery);
        $tokens[] = self::MYSQL_KEYWORD_FROM;
        $tokens[] = $this->getStore($selectQuery);

        $tokens = $this->addFilterCriteriaToTokens($selectQuery, $tokens);

        return implode(' ', $tokens);
    }


    /**
     * @param SelectQuery $selectQuery
     * @return string
     */
    private function getStore(SelectQuery $selectQuery)
    {
        if ($selectQuery->getDb() !== null) {
            return $selectQuery->getDb() . '.' . $selectQuery->getTable();
        } else {
            return $selectQuery->getTable();
        }
    }

    /**
     * @param SelectQuery $selectQuery
     * @return string
     */
    private function getFields(SelectQuery $selectQuery)
    {
        if ($selectQuery->getFields() === null) {
            return self::MYSQL_SYNTAX_ALL_FIELDS;
        } else {
            return implode(', ', $selectQuery->getFields());
        }
    }

    /**
     * @param SelectQuery $selectQuery
     * @param $tokens
     * @return array
     */
    public function addFilterCriteriaToTokens(SelectQuery $selectQuery, $tokens)
    {
        if ($selectQuery->getWhere() !== null) {
            $tokens[] = self::MYSQL_KEYWORD_WHERE;

            $tokens = $this->buildTokensForExpression($selectQuery->getWhere(), $tokens);
        }

        return $tokens;
    }

    /**
     * @param MultiPartExpression $expression
     * @param array $tokens
     * @return array
     */
    private function buildTokensForExpression(MultiPartExpression $expression, array $tokens)
    {
        $value = $expression->getValue();
        $operation = $expression->getOperation();
        $operand = $expression->getOperand();

        if ($value->getType() == Expression::EXPRESSION_TYPE_COMPARISON
            || $value->getType() == Expression::EXPRESSION_TYPE_CONDITIONAL
        ) {
            $tokens = $this->buildTokensForExpression($value, $tokens);
        } else {
            $tokens[] = $this->addLiteral($value);
        }

        $tokens[] = $operation->getOperation();

        if ($operand->getType() == Expression::EXPRESSION_TYPE_COMPARISON
            || $operand->getType() == Expression::EXPRESSION_TYPE_CONDITIONAL
        ) {
            $tokens = $this->buildTokensForExpression($operand, $tokens);
        } else {
            $tokens[] = $this->addLiteral($operand);
        }

        return $tokens;
    }

    private function addLiteral(Expression $expression)
    {
        if ($expression->getType() == Expression::EXPRESSION_TYPE_LITERAL) {
            if (is_string($expression->getValue())) {
                return "'" . $expression->getValue() . "'";
            }
        }

        return $expression->getValue();
    }
}

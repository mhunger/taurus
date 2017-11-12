<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:49
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\expression\Expression;
use taurus\framework\db\query\expression\MultiPartExpression;
use taurus\framework\db\query\JoinStatement;
use taurus\framework\db\query\SelectQuery;
use taurus\framework\db\query\SelectQueryStringBuilder;
use taurus\framework\util\MysqlUtils;

class MysqlSelectQueryStringBuilder implements SelectQueryStringBuilder
{

    const MYSQL_SYNTAX_ALL_FIELDS = '*';

    const MYSQL_KEYWORD_SELECT = 'SELECT';

    const MYSQL_KEYWORD_JOIN = 'LEFT JOIN';

    const MYSQL_KEYWORD_ON = 'ON';

    const MYSQL_KEYWORD_FROM = 'FROM';

    const MYSQL_KEYWORD_LIMIT = 'LIMIT';

    const MYSQL_KEYWORD_OFFSET = 'OFFSET';

    /**
     * @var MysqlUtils
     */
    private $utils;

    /**
     * MysqlSelectQueryStringBuilder constructor.
     * @param MysqlUtils $utils
     */
    public function __construct(MysqlUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * @param SelectQuery $selectQuery
     * @return string
     */
    public function getSelectQueryString(SelectQuery $selectQuery)
    {
        $tokens = [];
        $tokens[] = self::MYSQL_KEYWORD_SELECT;
        $tokens[] = $this->getFields($selectQuery);
        $tokens[] = self::MYSQL_KEYWORD_FROM;
        $tokens[] = $this->getStore($selectQuery);
        $tokens = $this->addJoinStatements($selectQuery, $tokens);
        $tokens = $this->addFilterCriteriaToTokens($selectQuery, $tokens);
        $tokens = $this->getLimitAndOffset($selectQuery, $tokens);

        return implode(' ', $tokens);
    }

    /**
     * @param SelectQuery $selectQuery
     * @param array $tokens
     * @return array
     */
    private function addJoinStatements(SelectQuery $selectQuery, array $tokens): array
    {
        $joins = $selectQuery->getJoin();

        /** @var JoinStatement $joinStatement */
        foreach ($joins as $joinStatement) {
            $tokens[] = self::MYSQL_KEYWORD_JOIN;
            $tokens[] = $this->utils->addMysqlTicks($joinStatement->getTable());
            $tokens[] = self::MYSQL_KEYWORD_ON;
            $tokens[] = $this->utils->addMysqlTicks($joinStatement->getTable()) . '.' . $this->utils->addMysqlTicks($joinStatement->getField());
            $tokens[] = '=';
            $tokens[] = $this->utils->addMysqlTicks($selectQuery->getTable()) . '.' . $this->utils->addMysqlTicks($joinStatement->getReferenceField());
        }

        return $tokens;
    }

    /**
     * @param $token
     * @return string
     */
    private function addMysqlTicks($token): string
    {
        return '`' . $token . '`';
    }

    /**
     * @param SelectQuery $selectQuery
     * @param $tokens
     * @return array
     */
    private function addFilterCriteriaToTokens(SelectQuery $selectQuery, $tokens)
    {
        if ($selectQuery->getWhere() !== null) {
            $tokens[] = MySqlQueryStringBuilderImpl::MYSQL_KEYWORD_WHERE;

            $tokens = $this->buildTokensForExpression($selectQuery->getWhere(), $tokens);
        }

        return $tokens;
    }


    /**
     * @param SelectQuery $selectQuery
     * @return string
     */
    private function getStore(SelectQuery $selectQuery)
    {
        if ($selectQuery->getDb() !== null) {
            return $this->utils->addMysqlTicks($selectQuery->getDb()) . '.' . $this->utils->addMysqlTicks($selectQuery->getTable());
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
            return $this->buildFieldList($selectQuery);
        }
    }

    /**
     * @param SelectQuery $selectQuery
     * @return string
     * @internal param array $fieldList
     */
    private function buildFieldList(SelectQuery $selectQuery): string
    {
        $fieldsWithTableName = [];

        foreach($selectQuery->getFields() as $table => $fieldName) {
            if(!is_numeric($table)) {
                $fieldsWithTableName[] = $this->addMysqlTicks($table) . '.' . $this->addMysqlTicks($fieldName);
            } else {
                $fieldsWithTableName[] = $this->getStore($selectQuery) . '.' . $this->addMysqlTicks($fieldName);
            }
        }

        return implode(', ', $fieldsWithTableName);

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

    /**
     * @param Expression $expression
     * @return string|Expression
     */
    private function addLiteral(Expression $expression)
    {
        if ($expression->getType() == Expression::EXPRESSION_TYPE_LITERAL) {
            if (is_string($expression->getValue())) {
                return "'" . $expression->getValue() . "'";
            }
        }

        return $expression->getValue();
    }

    /**
     * @param SelectQuery $selectQuery
     * @return int|null
     */
    private function getLimit(SelectQuery $selectQuery): ?int
    {
        return $selectQuery->getLimit();
    }

    /**
     * @param SelectQuery $selectQuery
     * @return int
     */
    private function getOffset(SelectQuery $selectQuery): int
    {
        if($selectQuery->getOffset() === null) {
            return 0;
        }

        return $selectQuery->getOffset();
    }

    /**
     * @param SelectQuery $selectQuery
     * @param array $tokens
     * @return array
     */
    private function getLimitAndOffset(SelectQuery $selectQuery, array $tokens): array
    {
        $limit = $this->getLimit($selectQuery);
        $offset = $this->getOffset($selectQuery);

        if($limit === null) {
            return $tokens;
        }

        $tokens[] = self::MYSQL_KEYWORD_LIMIT;
        $tokens[] = $limit;

        if($offset >= 0) {
            $tokens[] = self::MYSQL_KEYWORD_OFFSET;
            $tokens[] = $offset;
        }

        return $tokens;
    }
}

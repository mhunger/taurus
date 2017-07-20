<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 19:46
 */

namespace taurus\framework\annotation;


class Column extends AbstractAnnotation
{
    const ANNOTATOIN_NAME_COLUMN = 'Column';

    /** @var string */
    private $type;

    /** @var string */
    private $columnName;

    /**
     * Column constructor.
     * @param string $property
     * @param string $name
     * @param string $type
     */
    public function __construct(string $property, string $name, string $type = null)
    {
        parent::__construct($property, self::ANNOTATOIN_NAME_COLUMN);
        $this->columnName = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }
}

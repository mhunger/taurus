<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/06/18
 * Time: 18:38
 */

namespace taurus\framework\db\query;


class SelectItemFunction implements SelectItem
{

    /** @var string */
    private $function;

    /** @var string */
    private $alias;

    /** @var array */
    private $params;

    /**
     * SelectItemFunction constructor.
     * @param string $function
     * @param string $alias
     * @param array $params
     */
    public function __construct($function, $alias, array $params)
    {
        $this->function = $function;
        $this->alias = $alias;
        $this->params = $params;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return SelectItem::SELECT_ITEM_TYPE_FUNCTION;
    }

    /**
     * @return null|string
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->function;
    }

    /**
     * @return array|null
     */
    public function getParameters(): ?array
    {
        return $this->params;
    }
}
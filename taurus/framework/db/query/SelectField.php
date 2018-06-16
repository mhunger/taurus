<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/06/18
 * Time: 18:33
 */

namespace taurus\framework\db\query;


class SelectField implements SelectItem
{

    /** @var string */
    private $field;

    /** @var string */
    private $alias;

    /**
     * SelectField constructor.
     * @param string $table
     * @param string $field
     * @param string $alias
     */
    public function __construct(string $table = null, string $field, string $alias = null)
    {
        $this->field = $field;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return SelectItem::SELECT_ITEM_TYPE_FIELD;
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
        return $this->field;
    }

    /**
     * @return array|null
     */
    public function getParameters(): ?array
    {
        return null;
    }}
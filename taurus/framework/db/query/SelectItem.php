<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/06/18
 * Time: 18:35
 */

namespace taurus\framework\db\query;


interface SelectItem
{
    const SELECT_ITEM_TYPE_FIELD = 0;

    const SELECT_ITEM_TYPE_LITERAL = 1;

    const SELECT_ITEM_TYPE_FUNCTION = 2;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getAlias(): ?string;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return array|null
     */
    public function getParameters(): ?array;
}
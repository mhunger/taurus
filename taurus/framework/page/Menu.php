<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:09
 */

namespace taurus\framework\page;


class Menu
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var array */
    protected $menuItems;

    /**
     * Menu constructor.
     * @param string $name
     * @param string $type
     * @param array $menuItems
     */
    public function __construct($name, $type, array $menuItems)
    {
        $this->name = $name;
        $this->type = $type;
        $this->menuItems = $menuItems;
    }
}
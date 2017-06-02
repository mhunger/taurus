<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:09
 */

namespace taurus\framework\page;


class MenuItem
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $path;

    /** @var Component */
    protected $component;

    /**
     * MenuItem constructor.
     * @param string $name
     * @param string $path
     * @param Component $component
     */
    public function __construct($name, $path, Component $component)
    {
        $this->name = $name;
        $this->path = $path;
        $this->component = $component;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return Component
     */
    public function getComponent(): Component
    {
        return $this->component;
    }

}
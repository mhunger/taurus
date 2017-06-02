<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:09
 */

namespace taurus\framework\page;


class Page
{
    /** @var string */
    private $title;

    /** @var array */
    private $components;

    /**
     * Page constructor.
     * @param string $title
     * @param array $components
     */
    public function __construct($title, array $components)
    {
        $this->title = $title;
        $this->components = $components;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }
}
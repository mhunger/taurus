<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 31/07/17
 * Time: 17:10
 */

namespace bin\tpl;


use const null;

class TemplateVar
{
    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    /**
     * TemplateVar constructor.
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, mixed $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}

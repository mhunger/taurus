<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 31/07/17
 * Time: 17:09
 */

namespace bin\tpl;


use function str_replace;

class TemplateBlock
{
    /** @var string */
    private $name;

    /** @var array */
    private $variables = [];

    /** @var string */
    private $snippet;

    /** @var string */
    private $renderedSnippet;

    /**
     * TemplateBlock constructor.
     * @param string $name
     * @param array $variables
     * @param string $snippet
     */
    public function __construct($name, array $variables, $snippet)
    {
        $this->name = $name;
        $this->variables = $variables;
        $this->originalSnippet = $snippet;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @return string
     */
    public function getSnippet(): string
    {
        return $this->snippet;
    }

    public function renderBlock()
    {
        /** @var TemplateVar $variable */
        foreach ($this->variables as $variable) {
            $this->renderedSnippet = str_replace($variable->getName(), $variable->getValue(), $this->snippet);
        }
    }
}
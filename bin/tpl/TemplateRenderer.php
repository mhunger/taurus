<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 31/07/17
 * Time: 17:12
 */

namespace bin\tpl;


use function file_get_contents;
use function is_array;
use const PHP_EOL;
use function preg_match;
use function preg_match_all;
use const PREG_SET_ORDER;
use function print_r;

class TemplateRenderer
{
    const block_name = 'blockname';

    const block_content = 'blockcontent';

    const var_name = 'varname';

    /** @var string */
    private $tplFile;

    /** @var string */
    private $tplContent;

    /** @var array */
    private $parsedBlocks = [];

    private $blockData = [];

    /**
     * TemplateRenderer constructor.
     * @param string $tplFile
     * @internal param array $blocks
     */
    public function __construct($tplFile)
    {
        $this->tplFile = $tplFile;
        $this->tplContent = file_get_contents($tplFile);

        $this->parseTemplate();
    }

    public function render()
    {
        /** @var TemplateBlock $block */
        foreach ($this->blockData as $block) {
            $block->
        }

    }

    public function setBlockData(string $name, array $data)
    {
        $this->blockData[$name] = $this->buildTemplateVars($data);
    }

    private function buildTemplateVars(array $variables): array
    {
        
        foreach ($variables as $varname => $value) {

        }
    }

    /**
     * Parses the blocks and block variables for the template. This results in the object
     * Structure.
     *
     */
    private function parseTemplate()
    {
        /** '/\/\*\*\sBLOCK\s([a-z-]+)\s\*\/\s(.*)\s\/\*\*\sBLOCKEND\s([a-z-]+)\s\*\//', */
        preg_match_all(
            '/\/\*\*\sBLOCK\s(?<'. self::block_name . '>[a-z-]+)\s\*\/(?<' . self::block_content . '>.*)\/\*\*\sBLOCKEND\s([a-z-]+)\s\*\//Us',
            $this->tplContent,
            $blocks,
            PREG_SET_ORDER
        );

        $this->createBlocks($blocks);
    }

    /**
     * @param array $blocks
     */
    private function createBlocks(array $blocks) {
        foreach ($blocks as $block) {
            $this->parseVars($block[self::block_content]);

            $this->parsedBlocks[$block[self::block_name]] =
                    $this->parseVars($block[self::block_content]);
        }
    }

    /**
     * @param string $vars
     * @return array
     */
    private function parseVars(string $vars): array
    {
        preg_match_all(
            '/##(?<' . self::var_name . '>[a-z-]+)##/',
            $vars,
            $parsedVars,
            PREG_SET_ORDER
        );

        $return = [];
        foreach ($parsedVars as $parsedVar) {
            $return[$parsedVar[self::var_name]] = $parsedVar[self::var_name];
        }

        return $return;
    }
}

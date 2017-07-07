<?php

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 07/07/17
 * Time: 09:28
 */
abstract class AbstractTemplate
{

    private $tplFile;

    private $tplTarget;

    private $tplContent;

    /**
     * @var ConfigFileTemplateData
     */
    protected $data;

    /**
     * AbstractTemplate constructor.
     * @param $tplFilePath
     * @param $tplTarget
     * @param ConfigFileTemplateData $data
     */
    public function __construct($tplFilePath, $tplTarget, ConfigFileTemplateData $data)
    {
        $this->tplFile = $tplFilePath;
        $this->tplTarget = $tplTarget;
        $this->data = $data;
        $this->tplContent = file_get_contents($this->tplFile);
    }

    abstract function render();

    protected function setVars(array $vars)
    {
        foreach($vars as $name => $val) {
            Taurus::info('Replacing', $name . '/' . $val);
            $this->tplContent = str_replace('##' . $name . '##', $val, $this->tplContent);
        }
    }

    /**
     * @return bool|string
     */
    public function getTplContent()
    {
        return $this->tplContent;
    }

    public function writeContent(string $target = null, $filename = null)
    {
        if($target === null) {
            $fh = fopen($this->tplTarget, 'w');
        } else {
            $fh = fopen($target . '/' . $filename, 'w');
        }
        fwrite($fh, $this->getTplContent());
        fclose($fh);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:18
 */

namespace taurus\framework\page;


use taurus\framework\annotation\Entity;
use taurus\framework\routing\BasicRoute;

class FormComponent
{
    /** @var BasicRoute */
    protected $postApi;

    /** @var BasicRoute */
    protected $putApi;

    /** @var Entity */
    protected $entity;

    /**
     * FormComponent constructor.
     * @param BasicRoute $postApi
     * @param BasicRoute $putApi
     * @param Entity $entity
     */
    public function __construct(BasicRoute $postApi, BasicRoute $putApi, Entity $entity)
    {
        $this->postApi = $postApi;
        $this->putApi = $putApi;
        $this->entity = $entity;
    }
}

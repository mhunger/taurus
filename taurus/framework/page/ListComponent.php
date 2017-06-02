<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:16
 */

namespace taurus\framework\page;


use taurus\framework\annotation\Entity;
use taurus\framework\routing\BasicRoute;

class ListComponent extends Component
{
    /** @var BasicRoute */
    protected $getApi;

    /** @var Entity */
    protected $entity;

    /**
     * ListComponent constructor.
     * @param BasicRoute $getApi
     * @param string $entity
     */
    public function __construct(BasicRoute $getApi, string $entity)
    {
        $this->getApi = $getApi;
        $this->entity = $entity;
    }

    /**
     * @return BasicRoute
     */
    public function getGetApi(): BasicRoute
    {
        return $this->getApi;
    }

    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }
}

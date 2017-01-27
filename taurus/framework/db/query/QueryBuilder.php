<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:06
 */

namespace taurus\framework\db\query;


/**
 * Class that will manage building queries on QAL, so language-independent
 *
 * Class QueryBuilder
 * @package taurus\framework\db\query
 */
class QueryBuilder
{

    /** @var Query */
    private $query;

    public function query()
    {
        $this->query = new SelectQuery();

        return $this->query;
    }
}
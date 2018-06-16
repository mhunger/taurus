<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 16:37
 */

namespace taurus\framework\db\query;

/**
 * Class Specification
 * @package taurus\framework\db\query
 *
 * Parent class for all specifications that are there to represent a specific query
 * The parent class will ensure all specification are able to return their specs in
 * normalised form e.g. through expressions
 *
 */
interface Specification
{
    /**
     * Return the table for which this specification is
     *
     * @return string
     */
    public function getTable(): string;


    /**
     * Return the select statement replaceing some data in the query
     * @return array|null|string
     */
    public function getSelect(): ?array;
}

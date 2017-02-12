<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:21
 */

namespace taurus\framework\db\query;

use taurus\framework\db\query\InsertQueryStringBuilder;
use taurus\framework\db\query\SelectQueryStringBuilder;


/**
 * Used for objects that build concrete query strings from QAL structures
 *
 * Interface QueryStringBuilder
 * @package taurus\framework\db\query
 */
interface QueryStringBuilder extends SelectQueryStringBuilder, InsertQueryStringBuilder, DeleteQueryStringBuilder
{
}
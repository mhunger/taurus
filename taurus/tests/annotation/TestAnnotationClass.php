<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:51
 */

namespace taurus\tests\annotation;

/**
 * Class TestAnnotationClass
 * @Entity(name="test")
 */
class TestAnnotationClass {

    /**
     * @var string
     * @Column(name="id")
     */
    public $test;

    /**
     * @autowired
     */
    public $instance;

    /**
     * @setter(name="prop")
     */
    public function method() {

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 20:03
 */

namespace taurus\tests\fixtures;


use taurus\framework\db\query\Specification;

class TestSpecificationEven implements Specification
{
    /**
     * @var string
     * @Spec(column="spec_1", filterType="equals", argumentType="string")
     */
    private $spec1;

    /**
     * @var
     * @Spec(column="spec_2", filterType="smallerthan", argumentType="number")
     */
    private $spec2;

    /**
     * @var
     * @Spec(column="spec_3", filterType="greaterthan", argumentType="string")
     */
    private $spec3;

    /**
     * @var
     * @Spec(column="spec_4", filterType="like", argumentType="number")
     */
    private $spec4;

    /**
     * TestSpecification constructor.
     * @param string $spec1
     * @param $spec2
     * @param $spec3
     * @param $spec4
     */
    public function __construct($spec1, $spec2, $spec3, $spec4)
    {
        $this->spec1 = $spec1;
        $this->spec2 = $spec2;
        $this->spec3 = $spec3;
        $this->spec4 = $spec4;
    }

    /**
     * @return string
     */
    public function getSpec1(): string
    {
        return $this->spec1;
    }

    /**
     * @return mixed
     */
    public function getSpec2()
    {
        return $this->spec2;
    }

    /**
     * @return mixed
     */
    public function getSpec3()
    {
        return $this->spec3;
    }

    /**
     * @return mixed
     */
    public function getSpec4()
    {
        return $this->spec4;
    }

    /**
     * Return the table for which this specification is
     *
     * @return string
     */
    public function getTable(): string
    {
        return 'test_table';
    }

    public function getSelect(): ?string
    {
        return null;
    }
}

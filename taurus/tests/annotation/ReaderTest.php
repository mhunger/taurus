<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:47
 */

namespace taurus\tests\annotation;


use PHPUnit\Framework\TestCase;
use taurus\framework\annotation\AbstractAnnotation;
use taurus\framework\annotation\Annotation;
use taurus\framework\annotation\AnnotationProperty;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\annotation\Column;
use taurus\framework\annotation\Entity;
use taurus\framework\annotation\OneToOne;
use taurus\framework\annotation\Setter;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;

use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\tests\AbstractTaurusTest;


class ReaderTest extends AbstractTaurusTest
{

    /** @var AnnotationReader */
    private $testSubject;

    public function setUp() {
        parent::setUp();
        $this->testSubject = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ANNOTATION_READER);
        $this->testSubject->getAnnotationsForClass(
                new \ReflectionClass(new TestAnnotationClass())
        );
    }

    public function testParseClassAnnotations()
    {
        $expectedAnnotation = new Entity('taurus\tests\annotation\TestAnnotationClass', 'test');

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getClassAnnotations()['Entity'],
            "Entity Property does not Exist"
        );
    }

    public function testParsePropertyAnnotations() {
        $expectedAnnotation = new Column('test', 'id');

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getPropertyAnnotations()['test']['Column']
        );

    }

    public function testParseAnnoationMultipleProps()
    {
        $property = 'entity';
        $expectedAnnotation = new OneToOne($property, '\taurus\framework\db\Entity\TestEntity', 'entity_id_column', 'test_table', 'id_test');

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getAnnotationsForProperty($property)[EntityMetaDataStore::ANNOTATION_ENTITY_REL_ONE_TO_ONE],
            'Could not parse OneToOne annotation correctly'
        );
    }

    public function testParseMethodAnnotations() {
        $expectedAnnotation = new Setter(
            'method',
            'id'
        );

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getMethodAnnotations()['method']['Setter'],
            "Method AbstractAnnotation was not parsed correct"
        );
    }

    public function testGetPropertyForAnnotation()
    {
        $expectedProperty = 'id';
        $actualProperty = $this->testSubject->getPropertyForAnnotation(EntityMetaDataStore::ENTITY_ANNOTATION_ID);

        $this->assertEquals(
            $expectedProperty,
            $actualProperty,
            "Could not read property correct. Expected [" . $expectedProperty . '] got [' . $actualProperty . ']'
        );
    }
}

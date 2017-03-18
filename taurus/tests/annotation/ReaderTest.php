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
use taurus\framework\annotation\AnnotationProperty;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\annotation\Column;
use taurus\framework\annotation\Entity;
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

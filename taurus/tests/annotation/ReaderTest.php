<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:47
 */

namespace taurus\tests\annotation;


use PHPUnit\Framework\TestCase;
use taurus\framework\annotation\Annotation;
use taurus\framework\annotation\AnnotationProperty;
use taurus\framework\annotation\Reader;
use taurus\framework\Container;
use taurus\framework\container\TaurusContainerConfig;
use taurus\tests\annotation\TestAnnotationClass;

class ReaderTest extends TestCase {

    /** @var Reader */
    private $testSubject;

    public function setUp() {
        $this->testSubject = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ANNOTATION_READER);
        $this->testSubject->parseAnnotations(
            new \ReflectionClass(
                new TestAnnotationClass()
            )
        );
    }

    public function testParseClassAnnotations() {

        $annotationProperty = new AnnotationProperty('name', 'test');
        $expectedAnnotation = new Annotation('Entity', [$annotationProperty]);

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getClassAnnotations()['Entity'],
            "Entity Property does not Exist"
        );
    }

    public function testParsePropertyAnnotations() {
        $expectedAnnotation = new Annotation('autowired');

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getPropertyAnnotations()['instance']['autowired']
        );

    }

    public function testParseMethodAnnotations() {
        $expectedAnnotation = new Annotation(
            'setter',
            [
                new AnnotationProperty('name', 'prop')
            ]
        );

        $this->assertEquals(
            $expectedAnnotation,
            $this->testSubject->getMethodAnnotations()['method']['setter'],
            "Method Annotation was not parsed correct"
        );
    }
}
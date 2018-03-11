<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 12:59
 */

namespace taurus\framework\annotation;


class AnnotationParser {

    /** @var AnnotationBuilder */
    private $annotationBuilder;

    /**
     * AnnotationParser constructor.
     * @param AnnotationBuilder $annotationBuilder
     */
    public function __construct(AnnotationBuilder $annotationBuilder)
    {
        $this->annotationBuilder = $annotationBuilder;
    }

    /**
     * @param string $docCommentString
     * @param string $classMember
     * @return array
     */
    public function parseDocComment(string $docCommentString, string $classMember): array
    {
        $result = [];

        $annotationCollection = [];

        if(preg_match_all('/@([A-Z_a-z]+)(\(.+\))?/', $docCommentString, $result, PREG_SET_ORDER) > 0) {
            foreach($result as $annotation) {

                if (!in_array($annotation[1], AnnotationBuilder::DOC_BLOCK_ANNOATIONS)) {
                    if (isset($annotation[2])) {
                        $properties = $this->parseProperties($annotation[2], $annotation[1]);
                        $annotationCreated = $this->annotationBuilder->build($annotation[1], $classMember, $properties);
                    } else {
                        $annotationCreated = $this->annotationBuilder->build($annotation[1], $classMember);
                    }

                    $annotationCollection[$annotation[1]] = $annotationCreated;

                } else {

                }
            }
        }

        return $annotationCollection;
    }

    /**
     * @param string $stringToParse
     * @param string $name
     * @return array
     */
    public function parseProperties(string $stringToParse, string $name): array
    {
        $properties = [];

        $pattern = '/([a-zA-Z_]+)\s?=\s?"?([a-zA-z_\-0-9]+)"?/';

        if(preg_match_all($pattern, $stringToParse, $result, PREG_SET_ORDER) > 0) {
            foreach($result as $annotation) {
                $properties[$annotation[1]] = $annotation[2];
            }
        }

        return $properties;
    }
}

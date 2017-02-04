<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 12:59
 */

namespace taurus\framework\annotation;


class AnnotationParser {


    /**
     * @param $docCommentString
     * @return array
     */
    public function parseDocComment($docCommentString) {
        $result = [];

        $annotationCollection = [];

        if(preg_match_all('/@([A-Za-z]+)(\(.+\))?/', $docCommentString, $result, PREG_SET_ORDER) > 0) {
            foreach($result as $annotation) {

                if(isset($annotation[2])) {
                    $annotationParsed = $this->parseProperties($annotation[2], new Annotation($annotation[1]));

                } else {
                    $annotationParsed = new Annotation($annotation[1]);
                }

                $annotationCollection[$annotationParsed->getName()] = $annotationParsed;
            }
        }

        return $annotationCollection;
    }

    /**
     * @param $stringToParse
     * @param Annotation $annotationObj
     * @return Annotation
     */
    public function parseProperties($stringToParse, Annotation $annotationObj)
    {
        $result = [];

        $pattern = '/\(([a-z]+)\s?=\s?"?([a-z0-9]+)"?\)/';

        if(preg_match_all($pattern, $stringToParse, $result, PREG_SET_ORDER) > 0) {
            foreach($result as $annotation) {
                $annotationProperty = new AnnotationProperty($annotation[1], $annotation[2]);
                $annotationObj->addProperty($annotationProperty);
            }
        }

        return $annotationObj;
    }
}
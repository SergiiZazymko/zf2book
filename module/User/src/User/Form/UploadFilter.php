<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 14:23
 */

namespace User\Form;


use Zend\Filter\HtmlEntities;
use Zend\Filter\StripTags;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

class UploadFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'label',
            'required' => true,
            'filters' => [
                [
                    'name' => StripTags::class,
                ],
                [
                    'name' => HtmlEntities::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
                        'messages' => [
                            StringLength::TOO_SHORT => 'String must be from 2 to 140',
                            StringLength::TOO_LONG => 'String must be from 2 to 140',
                        ]
                    ],
                ],
            ],
        ]);

//        $this->add([
//            'name' => 'fileupload',
////            'required' => true,
////            'validators' => [
////                [
////                    'name' => FileInput::class,
////                ],
////            ],
//        ]);
    }
}
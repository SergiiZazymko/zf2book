<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 24.04.18
 * Time: 14:30
 */

namespace User\Form;


use Zend\Filter\HtmlEntities;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'name',
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
                        'max' => 10,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
        ]);
    }
}

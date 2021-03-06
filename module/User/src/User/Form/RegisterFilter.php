<?php

namespace User\Form;

use Zend\Filter\HtmlEntities;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'domain' => true,
                        'messages' => [
                            \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address invalid',
                            \Zend\Validator\EmailAddress::INVALID_HOSTNAME => 'Email hostname invalid',
                        ],
                    ],
                ],
            ],
        ]);

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
                        'max' => 140,
                        'messages' => [
                            StringLength::TOO_SHORT => 'String must be from 2 to 140',
                            StringLength::TOO_LONG => 'String must be from 2 to 140',
                        ]
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
        ]);

        $this->add([
            'name' => 'confirm_password',
            'required' => true,
        ]);
    }
}

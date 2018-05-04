<?php

namespace User\Form;

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
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
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
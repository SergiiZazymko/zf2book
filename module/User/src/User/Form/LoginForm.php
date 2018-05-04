<?php

namespace User\Form;


use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\Form\Form;
use Zend\Validator\EmailAddress;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Login');

        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'email',
            'attributes' => ['required' => 'required', 'type' => 'email'],
            'options' => ['label' => 'Email'],
            'filters' => [
                ['name' => HtmlEntities::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => EmailAddress::class],
                ['options' => ['messages' => [EmailAddress::INVALID_FORMAT => 'Email address invalid']]],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'attributes' => ['type' => 'password'],
            'options' => ['label' => 'Password'],
            'filters' => [
                ['name' => HtmlEntities::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => ['type' => 'submit', 'value' => 'Login'],
        ]);
    }
}

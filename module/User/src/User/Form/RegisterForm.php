<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/formdata');

        $this->add([
            'name' => 'name',
            'attributes' => ['type' => 'text'],
            'options' => ['label' => 'Full name'],
        ]);

        $this->add([
            'name' => 'email',
            'attributes' => ['type' => 'email', 'required' => 'required'],
            'options' => ['label' => 'Email'],
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'HtmlEntities'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => ['messages' => [\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address invalid']],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'attributes' => ['type' => 'password'],
            'options' => ['label' => 'Password'],
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'HtmlEntities'],
            ],
        ]);

        $this->add([
            'name' => 'confirm_password',
            'attributes' => ['type' => 'password'],
            'options' => ['label' => 'Confirm password'],
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'HtmlEntities'],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => ['type' => 'submit'],
        ]);
    }
}
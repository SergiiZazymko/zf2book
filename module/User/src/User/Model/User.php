<?php

namespace User\Model;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;

    public function setPassword($clearPassword)
    {
        $this->password = md5($clearPassword);
    }

    public function exchangeArray($data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }
}
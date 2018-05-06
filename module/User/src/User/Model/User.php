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
        foreach ($data as $key => $value) {
            if ($key != 'password') {
                if (property_exists(self::class, $key)) {
                    $this->$key = $value;
                }
            }
        }
        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }
}
<?php

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveUser(User $user)
    {
        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
        ];

        $id = (int) $user->id;

        if (0 == $id) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \Exception('User with this ID not found');
            }
        }
    }

    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception('Can not find user with this ID')
        }
        return $row;
    }
}
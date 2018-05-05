<?php

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Class UserTable
 * @package User\Model
 */
class UserTable
{
    /** @var TableGateway $tableGateway*/
    protected $tableGateway;

    const TABLE = 'user';

    /**
     * UserTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
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

    /**
     * @param $id
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception('Can not find user with this ID');
        }
        return $row;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUserByEmail($email)
    {
        $rowset = $this->tableGateway->select(['email' => $email]);
        $user = $rowset->current();
        if (!$user) {
            throw new \Exception('Can not find user with this email');
        }
        return $user;
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 13:01
 */

namespace User\Model;

/**
 * Class UploadTable
 * @package User\Model
 */
class UploadTable extends AbstractTable
{
    const TABLE = 'uploads';

    public function getItemByUserId($userId)
    {
        return $this->tableGateway->select(['user_id' => (int) $userId]);
    }
}
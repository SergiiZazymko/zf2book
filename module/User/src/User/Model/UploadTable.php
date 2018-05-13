<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 13:01
 */

namespace User\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class UploadTable
 * @package User\Model
 */
class UploadTable extends AbstractTable
{
    const TABLE = 'uploads';

    protected $uploadSharingTableGateway;

    public function __construct(TableGateway $tableGateway, TableGateway $uploadSharingTableGateway)
    {
        parent::__construct($tableGateway);
        $this->uploadSharingTableGateway = $uploadSharingTableGateway;
    }

    public function getItemsByUserId($userId)
    {
        return $this->tableGateway->select(['user_id' => (int) $userId]);
    }

    public function getUploadById($id)
    {
        return $this->tableGateway->select(['id' => (int) $id])->current();
    }

    public function addSharing($uploadId, $userId)
    {
        $data = [
            'upload_id' => $uploadId,
            'user_id' => $userId,
        ];

        $this->uploadSharingTableGateway->insert($data);
    }

    public function saveUpload(Upload $upload)
    {
        foreach ($upload as $property => $value) {
            if (null != $value) {
                $data[$property] = $value;
            }
        }

        $id = (int) $upload->id;

        if (0 == $id) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUploadById($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \Exception('Upload with this ID not found');
            }
        }
    }

    public function deleteSharing($uploadId, $userId)
    {
        $data = [
            'upload_id' => $uploadId,
            'user_id' => $userId,
        ];
        
        $this->uploadSharingTableGateway->delete($data);
    }

    public function getSharedUsers($uploadId)
    {
        $uploadId = (int) $uploadId;
        return $this->uploadSharingTableGateway->select(['upload_id' => $uploadId]);
    }

    public function getSharedUploadsForUserId($userId)
    {
        $userId = (int) $userId;
        return $this->uploadSharingTableGateway->select(function (Select $select) use ($userId) {
            $select->columns([])
                ->where(['uploads_sharing.user_id' => $userId])
                ->join('uploads', 'uploads_sharing.user_id = uploads.user_id    ');
        });
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 13:08
 */

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Class AbstractTable
 * @package User\Model
 */
abstract class AbstractTable
{
    /** @var TableGateway $tableGateway */
    protected $tableGateway;

    /**
     * UploadTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getItem($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $item = $rowset->current();
        if (!$item) {
            throw new \Exception('There is not item with this ID');
        }
        return $item;
    }

    public function saveItem(AbstractEntity $item)
    {
        foreach ($item as $property => $value) {
            $data[$property] = $value;
        }
        $id = (int) $item->id;
        if (!$id) {
            $this->tableGateway->insert($data);
        }
        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteItem($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
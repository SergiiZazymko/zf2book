<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 12:57
 */

namespace User\Model;


class Upload extends AbstractEntity
{
    /** @var int $id */
    public $id;
    /** @var string $filename */
    public $filename;
    /** @var string $label */
    public $label;
    /** @var int $user_id */
    public $user_id;

    public function exchangeArray($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists(self::class, $key)) {
                $this->$key = $value;
            }
        }
    }
}
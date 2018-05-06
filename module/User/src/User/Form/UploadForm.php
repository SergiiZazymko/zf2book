<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 14:01
 */

namespace User\Form;


use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct()
    {
        parent::__construct('Upload');
        $this->setAttribute('method', 'POST');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add([
            'name' => 'label',
            'attributes' => ['type' => 'text'],
            'options' => ['label' => 'File Description'],
        ]);

        $this->add([
            'name' => 'fileupload',
            'attributes' => ['type' => 'file'],
            'options' => ['label' => 'File Upload'],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => ['type' => 'submit'],
        ]);
    }
}

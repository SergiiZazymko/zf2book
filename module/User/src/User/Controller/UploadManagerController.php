<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 06.05.18
 * Time: 13:35
 */

namespace User\Controller;


use User\Form\UploadForm;
use User\Model\Upload;
use Zend\File\Transfer\Adapter\Http;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class UploadManagerController
 * @package User\Controller
 */
class UploadManagerController extends AbstractActionController
{
    /** @const string UPLOAD_URL */
    const UPLOAD_URL = 'http://localhost:8888/uploads/';

    /** @var $authService */
    private $authService;

    /**
     * @return array|object
     */
    protected function getAuthService()
    {
        if (!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authService;
    }

    /**
     * @return mixed
     */
    protected function getFileUploadLocation()
    {
        return $this->getServiceLocator()->get('config')['module_config']['upload_location'];
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userEmail = $this->getAuthService()->getStorage()->read();
        $user = $userTable->getUserByEmail($userEmail);

        $uploadTable->getSharedUploadsForUserId($user->id);

        $view = new ViewModel([
            'uploads' => $uploadTable->getItemsByUserId($user->id),
            'shared_uploads' => $uploadTable->getSharedUploadsForUserId($user->id),
        ]);

        return $view;
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function uploadAction()
    {
        $userEmail = $this->getAuthService()->getStorage()->read();
        $user = $this->getServiceLocator()->get('UserTable')->getUserByEmail($userEmail);

        $form = $this->getServiceLocator()->get('UploadForm');
        if ($this->getRequest()->isPost()) {
            $file = $this->params()->fromFiles('fileupload');
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
               $uploadPath = $this->getFileUploadLocation();
                $http = new Http();
                $http->setDestination($uploadPath);

                if (@$http->receive($file['www'])) {
                    $data['label'] = $this->getRequest()->getPost()['label'];
                    $data['filename'] = self::UPLOAD_URL .
                        str_replace('/tmp/', '', $file['tmp_name']) . '_' . $file['name'];
                    $data['user_id'] = $user->id;

                    $upload = new Upload();
                    $upload->exchangeArray($data);

                    $uploadTable = $this->getServiceLocator()->get('UploadTable');
                    $uploadTable->saveItem($upload);

                    return $this->redirect()->toRoute(null, ['controller' => 'UploadManager', 'action' => 'index']);
                }
            }
        }
        return new ViewModel(['form' => $form]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $fileName = $uploadTable->getItem($id)->filename;
        $fileName = explode('/', $fileName);
        $fileName = array_pop($fileName);
        $fileName = $this->getServiceLocator()->get('config')['module_config']['upload_location'] . DIRECTORY_SEPARATOR . $fileName;
        if (is_file($fileName)) {
            unlink($fileName);
        }
        $uploadTable->deleteItem($id);
        $this->redirect()->toRoute(null, ['controller' => 'UploadManager', 'action' => 'index']);
    }

    public function editAction()
    {
        $form = new UploadForm();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $form->setData($post);

            if ($form->isValid()) {
                $uploadTable = $this->getServiceLocator()->get('UploadTable');
                $upload = new Upload();
                $upload->exchangeArray($form->getData());
                $upload->id = $this->params()->fromRoute('id');
                $uploadTable->saveUpload($upload);
                $this->redirect()->toRoute(null, ['controller' => 'UploadManger', 'action' => 'index']);
            }
        }

        $id = $this->params()->fromRoute('id');

        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $upload = $uploadTable->getUploadById($id);
        $data['label'] = $upload->label;
        $data['filename'] = $upload->filename;
        $form->setData($data);

        $sharedUsers = $uploadTable->getSharedUsers($this->params()->fromRoute('id'));
        $userTable = $this->getServiceLocator()->get('UserTable');
        foreach ($sharedUsers as $user) {
            $users[] = $userTable->getUser($user->user_id);
        }

        return new ViewModel([
            'form' => $form,
            'shared_users' => $users,
        ]);
    }
}

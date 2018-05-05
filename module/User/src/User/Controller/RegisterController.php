<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 20.04.18
 * Time: 15:45
 */

namespace User\Controller;

use User\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('RegisterForm');
        $view = new ViewModel(['form' => $form]);
        return $view;
    }

    public function confirmAction()
    {
        return new ViewModel();
    }

    public function processAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->redirect()->toRoute(null, [
                'controller' => 'register',
                'action' => 'index',
            ]);
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel([
                'error' => true,
                'form' => $form,
            ]);
            $model->setTemplate('user/register/index');
            return $model;
        }

        $this->createUser($form->getData());
        return $this->redirect()->toRoute(null, [
            'controller' => 'register',
            'action' => 'confirm',
        ]);
    }

    protected function createUser($data)
    {
        $user = new User();
        $user->exchangeArray($data);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $userTable->saveUser($user);
        return true;
    }
}

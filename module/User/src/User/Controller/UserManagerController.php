<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 05.05.18
 * Time: 12:27
 */

namespace User\Controller;


use User\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserManagerController extends AbstractActionController
{
    public function indexAction()
    {
        $userTable = $this->getServiceLocator() ->get('UserTable');

        return new ViewModel(['users' => $userTable->fetchAll()]);
    }

    public function editAction()
    {
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->setData(['name' => $user->name]);
        $form->setData(['email' => $user->email]);
        $form->setData(['password' => $user->password]);
        $form->setData(['confirm_password' => $user->password]);
        return new ViewModel([
            'form' => $form,
            'userId' => $this->params()->fromRoute('id')
        ]);
    }

    public function processAction()
    {
        $post = $this->getRequest()->getPost();
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($post->id);
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->setData($post);
        $form->isValid();
        $user->name = $form->getData()['name'];
        $user->email = $form->getData()['email'];
        $this->getServiceLocator()->get('UserTable')->saveUser($user);
        $this->redirect()->toRoute(null, ['controller' => 'UserManager', 'action' => 'index']);
    }

    public function deleteAction()
    {
        $this->getServiceLocator()->get('UserTable')->deleteUser($this->params()->fromRoute('id'));
        return $this->redirect()->toRoute(null, ['controller' => 'UserManager', 'action' => 'index']);
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('RegisterForm');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $userTable = $this->getServiceLocator()->get('UserTable');
                $user = new User();
                $user->exchangeArray($data);
                $userTable->saveUser($user);
                $this->redirect()->toRoute(null, ['controller' => 'UserManager', 'action' => 'index']);
            }
        }
        return new ViewModel(['form' => $form]);
    }
}

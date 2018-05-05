<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 23.04.18
 * Time: 9:14
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public $authService;

    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('LoginForm');
        $view = new ViewModel(['form' => $form]);
        return $view;
    }

    public function processAction()
    {
        $this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('email'))
            ->setCredential($this->request->getPost('password'));
        $result = $this->getAuthService()->authenticate();
        if ($result->isValid()) {
            $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
            return $this->redirect()->toRoute(null, ['controller' => 'login', 'action' => 'confirm']);
        }
    }

    public function getAuthService()
    {
        if (!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authService;
    }

    public function confirmAction()
    {
        $userEmail = $this->getAuthService()->getStorage()->read();
        $viewModel = new ViewModel(['userEmail' => $userEmail]);
        return $viewModel;
    }
}

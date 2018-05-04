<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 20.04.18
 * Time: 15:45
 */

namespace User\Controller;


use User\Form\RegisterFilter;
use User\Form\RegisterForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new RegisterForm();
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
        $form = new RegisterForm();
        $form->setInputFilter(new RegisterFilter());
        $form->setData($post);
        if (!$form->isValid()) {
            $model = new ViewModel([
                'error' => true,
                'form' => $form,
            ]);
            $model->setTemplate('user/register/index');
            return $model;
        }

        return $this->redirect()->toRoute(null, [
            'controller' => 'register',
            'action' => 'confirm',
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 23.04.18
 * Time: 9:14
 */

namespace User\Controller;


use User\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new LoginForm();
        $view = new ViewModel(['form' => $form]);
        return $view;
    }
}
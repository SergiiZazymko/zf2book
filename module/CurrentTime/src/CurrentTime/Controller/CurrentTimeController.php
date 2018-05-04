<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 20.04.18
 * Time: 12:10
 */

namespace CurrentTime\Controller;

class CurrentTimeController extends \Zend\Mvc\Controller\AbstractActionController
{
    public function indexAction()
    {
        return new \Zend\View\Model\ViewModel();
    }
}
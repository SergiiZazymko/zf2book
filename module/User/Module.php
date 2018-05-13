<?php
namespace User;

use User\Form\LoginFilter;
use User\Form\LoginForm;
use User\Form\RegisterFilter;
use User\Form\RegisterForm;
use User\Form\UploadFilter;
use User\Form\UploadForm;
use User\Model\Upload;
use User\Model\UploadTable;
use User\Model\User;
use User\Model\UserTable;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            'abstract_factories' => [
                // ...
            ],
            'aliases' => [
                // ...
            ],
            'factories' => [
                'UploadTable' => function($sm) {
                    $tableGateway = $sm->get('UploadTableGateway');
                    $uploadSharingTableGateway = $sm->get('UploadSharingTableGateway');
                    return new UploadTable($tableGateway, $uploadSharingTableGateway);
                },
                'UploadTableGateway' => function($sm) {
                    $adapter = $sm->get(Adapter::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Upload());
                    $tableGateway = new TableGateway(UploadTable::TABLE, $adapter, null, $resultSetPrototype);
                    return $tableGateway;
                },
                'UserTable' => function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    return new UserTable($tableGateway);
                },
                'UserTableGateway' => function($sm) {
                    $adapter = $sm->get(Adapter::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    $tableGateway = new TableGateway(UserTable::TABLE, $adapter, null, $resultSetPrototype);
                    return $tableGateway;
                },
                'UploadForm' => function($sm) {
                    $uploadForm = new UploadForm();
                    $uploadForm->setInputFilter($sm->get('UploadFilter'));
                    return $uploadForm;
                },
                'LoginForm' => function($sm) {
                    $loginForm = new LoginForm();
                    $loginForm->setInputFilter($sm->get('LoginFilter'));
                    return $loginForm;
                },
                'RegisterForm' => function($sm) {
                    $registerForm = new RegisterForm();
                    $registerForm->setInputFilter($sm->get('RegisterFilter'));
                    return $registerForm;
                },
                'UploadFilter' => function() {
                    return new UploadFilter();
                },
                'LoginFilter' => function() {
                    return new LoginFilter();
                },
                'RegisterFilter' => function() {
                    return new RegisterFilter();
                },
                'AuthService' => function($sm) {
                    $dbAdapter = $sm->get(Adapter::class);
                    $dbTableAuthAdapter = new DbTable($dbAdapter, UserTable::TABLE,
                        'email', 'password', 'MD5(?)');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                'UploadSharingTableGateway' => function($sm) {
                    return new TableGateway('uploads_sharing', $sm->get(Adapter::class));
                }
            ],
            'invocables' => [
                // ...
            ],
            'services' => [
                // ...
            ],
            'shared' => [
                // ...
            ],
        ];
    }
}

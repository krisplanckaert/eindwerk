<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $form = new Application_Form_Signup();
        $postParams = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()) {
            if($form->isValid($postParams)) {
                $auth = Zend_Auth::getInstance();
                //meegeven welke database driver we gebruiken, is optioneel omdat we er momenteel maar 1 hebben
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'));
                $authAdapter->setTableName('user')
                            ->setIdentityColumn('name')
                            ->setCredentialColumn('password')
                            ->setIdentity($postParams['name'])
                            ->setCredential(md5($postParams['password']));
                //login uitvoeren
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()) {
                    //Alle artikels die in de winkelmand zitten linken aan die gebruiker
                    $basketModel = new Application_Model_Basket();
                    $basketModel->linkUser();
                    $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'index')));
                    //echo 'U bent ingelogd!';
                } else {
                    //alle foutmeldingen weergeven op het scherm
                    $this->view->messages = $result->getMessages();
                }
            } 
        }

    }
    
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'index')));
    }

}


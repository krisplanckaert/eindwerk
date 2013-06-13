<?php

class Admin_UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $userModel = new Application_Model_User();
        $this->view->users = $userModel->getAll()->toArray();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $userModel = new Application_Model_User();
        $user = $userModel->find($id)->current(); 
               
        $form = new Admin_Form_User($id);
        $form->populate($user->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            /*Zend_Debug::dump($postParams);
            die("ok");*/            
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $userModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/user/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'index')));
            }  
            
        }
        
    }

    public function toevoegenAction()
    {
        $form  = new Admin_Form_User;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $userModel = new Application_Model_User();
                $userModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $userModel = new Application_Model_User();
        $userModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'index')));
    }


}








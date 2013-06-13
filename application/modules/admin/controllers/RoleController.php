<?php

class Admin_RoleController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $roleModel = new Application_Model_Role();
        $this->view->roles= $roleModel->getAll()->toArray();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $roleModel = new Application_Model_Role();
        $role = $roleModel->find($id)->current(); 
               
        $form = new Admin_Form_Role($id);
        $form->populate($role->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            /*Zend_Debug::dump($postParams);
            die("ok");*/            
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $roleModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/role/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'Role', 'action'=> 'index')));
            }  
            
        }
        
    }

    public function toevoegenAction()
    {
        $form  = new Admin_Form_Role;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $roleModel = new Application_Model_Role();
                $roleModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Role', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $roleModel = new Application_Model_Role();
        $roleModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Role', 'action'=> 'index')));
    }


}








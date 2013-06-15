<?php

class Dealer_PhotoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $photoModel = new Application_Model_Photo();
        $this->view->photos= $photoModel->getAll()->toArray();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $photoModel = new Application_Model_Photo();
        $photo = $photoModel->find($id)->current(); 
               
        $form = new Application_Form_Photo($id);
        $form->populate($photo->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $photoModel->wijzigen($postParams, $id);
                
                $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'index')));
            }  
            
        }
        
    }

    public function toevoegenAction()
    {
        $form  = new Application_Form_Photo;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $photoModel = new Application_Model_Photo();
                $photoModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $photoModel = new Application_Model_Photo();
        $photoModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'index')));
    }


}








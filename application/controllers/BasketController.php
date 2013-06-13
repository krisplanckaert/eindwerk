<?php

class BasketController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $winkelmandModel = new Application_Model_Winkelmand();
        $where = 'session="'.session_id().'"';
        $this->view->winkelmanden = $winkelmandModel->getAll($where);
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $winkelmandModel = new Application_Model_Winkelmand();
        $winkelmand = $winkelmandModel->find($id)->current(); 
               
        $form = new Application_Form_Winkelmand($id);
        $form->populate($winkelmand->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            /*Zend_Debug::dump($postParams);
            die("ok");*/            
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $winkelmandModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/product/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'Winkelmand', 'action'=> 'index')));
            }  
        }
    }

    public function toevoegenAction()
    {
        $form  = new Application_Form_Winkelmand;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $winkelmandModel = new Application_Model_Winkelmand();
                $winkelmandModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Winkelmand', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $winkelmandModel = new Application_Model_Winkelmand();
        $winkelmandModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Winkelmand', 'action'=> 'index')));
    }


}








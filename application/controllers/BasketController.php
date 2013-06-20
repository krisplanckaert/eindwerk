<?php

class BasketController extends My_Controller_Action
{

    public function indexAction()
    {
        // action body
        $basketModel = new Application_Model_Basket();
        $this->view->basket = $basketModel->getBasket();
    }
    
    public function listAction() {
       $this->view->rows = $this->model->getBasket();
    } 
    
    public function changeAction()
    {
        $basketId = (int) $this->_getParam('basketId'); //$_GET['id];
                
        $basketModel = new Application_Model_Basket();
        $basket = $basketModel->find($basketId)->current(); 
               
        $form = new Application_Form_Basket($basketId);
        $form->populate($basket->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
           
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['lbl_add']);
                $basketModel->save($postParams, $basketId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'list')));
            }  
        }
    }

    public function addAction()
    {
        $form  = new Application_Form_Basket;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $basketModel = new Application_Model_Basket();
                $basketModel->add($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $basketId = (int) $this->_getParam('basketId'); 
        $basketModel = new Application_Model_Basket();
        $basketModel->remove($basketId);
        $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'list')));
    }

}








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
        $basketModel = new Application_Model_Basket();
        $this->view->basket = $basketModel->getBasket();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $basketModel = new Application_Model_Basket();
        $basket = $basketModel->find($id)->current(); 
               
        $form = new Application_Form_Basket($id);
        $form->populate($basket->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            /*Zend_Debug::dump($postParams);
            die("ok");*/            
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $basketModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/product/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'index')));
            }  
        }
    }

    public function toevoegenAction()
    {
        $form  = new Application_Form_Basket;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $basketModel = new Application_Model_Basket();
                $basketModel->add($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'index')));
            }            
        }
    }

    public function removeAction()
    {
        $basketId = (int) $this->_getParam('basketId'); 
        $basketModel = new Application_Model_Basket();
        $basketModel->remove($basketId);
        $this->_redirect($this->view->url(array('controller'=> 'Basket', 'action'=> 'index')));
    }


}








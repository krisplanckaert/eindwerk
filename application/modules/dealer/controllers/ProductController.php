<?php

class Admin_ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $productModel = new Application_Model_Product();
        $this->view->producten= $productModel->getAll()->toArray();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $productModel = new Application_Model_Product();
        $product = $productModel->find($id)->current(); 
               
        $form = new Application_Form_Product($id);
        $form->populate($product->toArray());
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            /*Zend_Debug::dump($postParams);
            die("ok");*/            
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $productModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/product/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'index')));
            }  
            
        }
        
    }

    public function toevoegenAction()
    {
        $form  = new Application_Form_Product;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $productModel = new Application_Model_Product();
                $productModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $productModel = new Application_Model_Product();
        $productModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'index')));
    }


}








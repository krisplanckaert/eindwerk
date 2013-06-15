<?php

class Dealer_ProductController extends My_Controller_Action
{

    public function changeAction()
    {
        $productId = (int) $this->_getParam('productId'); //$_GET['id];
                
        $productModel = new Application_Model_Product();
        $product = $productModel->find($productId)->current(); 
               
        $form = new Dealer_Form_Product($productId);
        $product = $product->toArray();
        $product = $productModel->getLocales($product);
        $form->populate($product);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $productModel->save($postParams, $productId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'list')));
            }  
            
        }
        
    }

    public function addAction()
    {
        $form  = new Dealer_Form_Product;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $productModel = new Application_Model_Product();
                $productModel->save($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $productId = (int) $this->_getParam('productId'); 
        $productModel = new Application_Model_Product();
        $productModel->delete('productId='.$productId);
        $this->_redirect($this->view->url(array('controller'=> 'Product', 'action'=> 'list')));
    }


}








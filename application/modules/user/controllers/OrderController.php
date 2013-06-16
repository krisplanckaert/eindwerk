<?php

class User_OrderController extends My_Controller_Action
{
    public function listAction() {
       $this->view->authUserRow = $this->authUserRow;
       if($this->authUserRow['roleId']<3) {
           $where = 'userId='.$this->authUserRow['userId'];
           $this->view->rows = $this->model->getAll($where);
       } else {
           $this->view->rows = $this->model->getAll();
       }
       
       
    }     
    
    public function changeAction()
    {
        $orderId = (int) $this->_getParam('orderId'); //$_GET['id];
                
        $orderModel = new Application_Model_Order();
        $order = $orderModel->find($orderId)->current(); 
               
        $form = new User_Form_Order($orderId);
        $order = $order->toArray();
        
        $form->populate($order);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $orderModel->save($postParams, $orderId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Order', 'action'=> 'list')));
            }  
        }
    }

    public function addAction()
    {
        $form  = new User_Form_Order;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $orderModel = new Application_Model_Order();
                $orderModel->save($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Order', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $orderId = (int) $this->_getParam('orderId'); 
        $orderModel = new Application_Model_Order();
        $orderModel->delete('orderId='.$orderId);
        $this->_redirect($this->view->url(array('controller'=> 'Order', 'action'=> 'list')));
    }


}








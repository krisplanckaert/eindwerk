<?php

class User_OrderdetailController extends My_Controller_Action
{

    public function listbyorderAction() {
        $orderId = (int) $this->_getParam('orderId'); 
        $where = 'orderId='.$orderId;
        $this->view->rows = $this->model->getAll($where);
        $this->view->authUserRow = $this->authUserRow;
    }
    
    public function changeAction()
    {
        $orderDetailId = (int) $this->_getParam('orderDetailId'); //$_GET['id];
                
        $orderdetailModel = new Application_Model_Orderdetail();
        $orderDetail = $orderdetailModel->find($orderDetailId)->current(); 
               
        $form = new User_Form_Orderdetail($orderDetailId);
        $order = $order->toArray();
        
        $form->populate($orderDetail);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $orderModel->save($postParams, $orderDetailId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Orderdetail', 'action'=> 'list')));
            }  
        }
    }

    public function addAction()
    {
        $form  = new User_Form_Orderdetail;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $orderModel = new Application_Model_Orderdetail();
                $orderModel->save($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Orderdetail', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $orderDetailId = (int) $this->_getParam('orderDetailId'); 
        $orderDetailModel = new Application_Model_Orderdetail();
        $orderDetailModel->delete('orderDetailId='.$orderDetailId);
        $this->_redirect($this->view->url(array('controller'=> 'Orderdetail', 'action'=> 'list')));
    }


}








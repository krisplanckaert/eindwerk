<?php
class Application_Model_Order extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'order';
    protected $_primary = 'orderId';

    public function init()
    {
        $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
        if($this->authUser) {
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();     
        }
    }
    
    public function createOrder($data) {
        $basketModel = new Application_Model_Basket();
        $orderdetailModel = new Application_Model_Orderdetail();
         
        $where = 'userId='.$this->authUserRow['userId'];
        $basket = $basketModel->getAll($where);
        $orderId = $this->insert($data);
         foreach($basket as $detail) {
            
            $orderDetailData['orderId'] = $orderId;
            $orderDetailData['quantity'] = $detail['quantity'];
            $orderDetailData['productId'] = $detail['productId'];
            $orderdetailModel->save($orderDetailData);
            $basketModel->delete('basketId='.$detail['basketId']);
        }
        return $orderId;
    }
        
}
?>

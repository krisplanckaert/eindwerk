<?php
class Application_Model_Order extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'order';
    protected $_primary = 'orderId';

    public function init()
    {
        $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
        $userModel = new Application_Model_User();
        $fields = array(
            'name' => $this->authUser
        );
        $this->authUserRow = $userModel->getOneByFields($fields);
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

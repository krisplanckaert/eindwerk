<?php
class Application_Model_Orderdetail extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'orderdetail';
    protected $_primary = 'orderDetailId';
    
    public function save($data, $id=null) {
        $productModel = new Application_Model_Product();
        $product = $productModel->getOne($data['productId']);
        $data['price'] = $product['price'];
        parent::save($data, $id);
    }
}
?>

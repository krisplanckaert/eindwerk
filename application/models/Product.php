<?php
class Application_Model_Product extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'product';
    protected $_primary = 'productId';
    
    public function getProductsByCategory($categoryId) {
        $select = $this->select()
                ->from(array('p'=>'product'))
                ->join(array('pc' => 'categoryproduct'), 'pc.productId=p.productId',null)
                ->where('pc.categoryId='.$categoryId);
        $result = $this->fetchAll($select);
        return $result;
        
    }
    
}
?>

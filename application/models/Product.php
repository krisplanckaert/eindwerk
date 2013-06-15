<?php
class Application_Model_Product extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'product';
    protected $_primary = 'productId';
    
    
    public function init() {
        $this->localeFields = array('title'=>'titel','teaser'=>'teaser');
    }
    
    public function getProductsByCategory($categoryId) {
        $select = $this->select()
                ->from(array('p' => $this->getTableName()))
                ->join(array('pc' => 'categoryproduct'), 'pc.productId=p.productId',null)
                ->where('pc.categoryId='.$categoryId);
        $result = $this->fetchAll($select);
        return $result;
        
    }
    
    public function getProductsList() {
        $return = array();
        $products = $this->getAll();
        foreach($products as $product) {
            $return[$product['productId']] = $product['label'];
        }
        return $return;
    }
}
?>

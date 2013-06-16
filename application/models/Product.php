<?php
class Application_Model_Product extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'product';
    protected $_primary = 'productId';
    
    
    public function init() {
        $this->localeFields = array('title'=>'title','teaser'=>'teaser','content'=>'content');
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
    
    public function getAllByDescription($locale, $params) {
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale', $locale); 
        $select = $this->select()
                ->from(array('p' => $this->getTableName()))
                ->joinleft(array('pl' => 'productlocale'), 'pl.productId=p.productId and pl.localeId='.$localeRow['localeId'],null)
                //->where('pl.localeId='.$localeRow['localeId'])
                ->where('pl.title like "%'.$params['description'].'%" or teaser like "%'.$params['description'].'%" or p.label like "%'.$params['description'].'%"');
        //echo $select;exit;
        $result = $this->fetchAll($select);
        return $result;
    }
}
?>

<?php
class Application_Model_Product extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'product';
    protected $_primary = 'productId';
    
    
    public function init() {
        $this->localeFields = array('title'=>'title','teaser'=>'teaser','content'=>'content');
        
        $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
        if($this->authUser) {
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();
        }
    }
    
    public function getProductsByCategory($categoryId) {
        $select = $this->select()
                ->from(array('p' => $this->getTableName()))
                ->join(array('pc' => 'categoryproduct'), 'pc.productId=p.productId',null)
                ->where('pc.categoryId='.$categoryId);
        $result = $this->fetchAll($select);
        return $result->toArray();
        
    }
    
    public function getPhotos($products, $array=false) {
        if($array) {
            foreach($products as $k => $product) {
                $products[$k]['productPhotos'] = $this->getPhotoDetail($product);
            }
        } else {
            $products['productPhotos'] = $this->getPhotoDetail($products);
        }
        return $products;
    }

    public function getPhotoDetail($product) {
        $productPhotoModel = new Application_Model_Productphoto();        
        $photoModel = new Application_Model_Photo();        
        $where = 'productId='.$product['productId'];
        $productPhotos = $productPhotoModel->getAll($where);
        foreach($productPhotos as $k2 => $productPhoto) {
            $photo = $photoModel->getOne($productPhoto['photoId']);
            $productPhotos[$k2] = $photo;
        }
        return $productPhotos;
    }
    
    public function getProductsList() {
        $return = array();
        $products = $this->getAll();
        $products = $this->getLocale($products, true);
        foreach($products as $product) {
            $return[$product['productId']] = isset($product['locale']['title']) ? $product['locale']['title'] : $product['label'];
        }
        return $return;
    }
    
    public function getAllByDescription($locale, $params) {
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale', $locale); 
        $select = $this->select()
                ->from(array('p' => $this->getTableName()))
                ->joinleft(array('pl' => 'productlocale'), 'pl.productId=p.productId and pl.localeId='.$localeRow['localeId'],null)
                //->where('pl.title like "%'.$params['description'].'%" or teaser like "%'.$params['description'].'%" or p.label like "%'.$params['description'].'%"');
                ->where('pl.title like "%'.$params['description'].'%" or teaser like "%'.$params['description'].'%"');
        //echo $select;exit;
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}
?>

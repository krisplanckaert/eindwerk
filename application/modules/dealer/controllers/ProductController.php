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
        
        $productPhotoModel = new Application_Model_Productphoto();
        $where = 'productId='.$productId;
        $productPhotos = $productPhotoModel->getAll($where);
        foreach($productPhotos as $productPhoto) {
            $product['photosId'][] = $productPhoto['photoId'];
        }
        
        $form->populate($product);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $this->toevoegenProductPhotos($postParams, $productId);                
                unset($postParams['photosId']);
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
                $productData = $postParams;
                unset($productData['photosId']);
                $productModel = new Application_Model_Product();
                $productId = $productModel->save($productData);
                $this->toevoegenProductPhotos($postParams, $productId); 
                
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

    public function toevoegenProductPhotos($postParams, $productId) {
        $productPhotoModel = new Application_Model_Productphoto();
        $where = 'productId='.$productId;
        $productPhotos = $productPhotoModel->getAll($where);
        foreach($productPhotos as $productPhoto) {
            if(!isset($postParams['photoId']) || !in_array($productPhoto['roleId'], $postParams['rolesId'])) {
                $where = 'productId='.$productId.' and photoId='.$productPhoto['photoId'];
                $productPhotoModel->delete($where);
            }
        }
        if(isset($postParams['photosId'])) {
            foreach($postParams['photosId'] as $photoId) {
                $fields = array(
                    'productId' => $productId,
                    'photoId' => $photoId,
                );
//Zend_Debug::dump($fields);exit;
                $productPhoto = $productPhotoModel->getOneByFields($fields);
                if(!$productPhoto) {
                    $data = array(
                        'productId' => $productId,
                        'photoId' => $photoId,
                    );
                    $productPhotoModel->insert($data);
                } 
            }
        }
    }


}








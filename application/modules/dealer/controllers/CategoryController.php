<?php

class Dealer_CategoryController extends My_Controller_Action
{

    public function changeAction()
    {
        $categoryId = (int) $this->_getParam('categoryId'); //$_GET['id];
                
        $categoryModel = new Application_Model_Category();
        $category = $categoryModel->find($categoryId)->current(); 
               
        $form = new Dealer_Form_Category($categoryId);
        $category = $category->toArray();
        $category = $categoryModel->getLocales($category);
        
        $categoryProductModel = new Application_Model_Categoryproduct();
        $where = 'categoryId='.$categoryId;
        $categoryProducts = $categoryProductModel->getAll($where);
        foreach($categoryProducts as $categoryProduct) {
            $category['productsId'][] = $categoryProduct['productId'];
        }
        $form->populate($category);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $this->toevoegenCategoryProducts($postParams, $categoryId);                
                unset($postParams['productsId']);
                $categoryModel->save($postParams, $categoryId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Category', 'action'=> 'list')));
            }  
            
        }
        
    }

    public function addAction()
    {
        $form  = new Dealer_Form_Category;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $CategoryData = $postParams;
                unset($postParams['productsId']);
                $categoryModel = new Application_Model_Category();
                $categoryId = $categoryModel->save($postParams);
                $this->toevoegenCategoryProducts($CategoryData, $categoryId);  
                
                $this->_redirect($this->view->url(array('controller'=> 'Category', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $categoryId = (int) $this->_getParam('categoryId'); 
        $categoryModel = new Application_Model_Category();
        $categoryModel->delete('categoryId='.$categoryId);
        $this->_redirect($this->view->url(array('controller'=> 'Category', 'action'=> 'list')));
    }

    public function toevoegenCategoryProducts($postParams, $categoryId) {
        $categoryProductModel = new Application_Model_CategoryProduct();
        $where = 'categoryId='.$categoryId;
        $categoryProducts = $categoryProductModel->getAll($where);
        foreach($categoryProducts as $categoryProduct) {
            if(!isset($postParams['productId']) || !in_array($categoryProduct['productsId'], $postParams['productsId'])) {
                $where = 'categoryId='.$categoryId.' and productId='.$categoryProduct['productId'];
                $categoryProductModel->delete($where);
            }
        }
        if(isset($postParams['productsId'])) {
            foreach($postParams['productsId'] as $productId) {
                $fields = array(
                    'categoryId' => $categoryId,
                    'productId' => $productId,
                );
                $categoryProduct = $categoryProductModel->getOneByFields($fields);
                if(!$categoryProduct) {
                    $data = array(
                        'categoryId' => $categoryId,
                        'productId' => $productId,
                    );
                    $categoryProductModel->insert($data);
                } 
            }
        }
    }


}








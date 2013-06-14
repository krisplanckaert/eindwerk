<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $categoryId = $this->_getParam('category',null);
        $productModel = new Application_Model_Product();
        $categoryModel = new Application_Model_Category();

        if($categoryId) {
            $this->view->producten = $productModel->getProductsByCategory($categoryId);
        }
        
        $this->view->categories = $categoryModel->getAllCategories();
    }

    public function detailAction()
    {
        $id = $this->_getParam('id');
        
        $productModel = new Application_Model_Product();
        $basketModel = new Application_Model_Basket();
        $product = $productModel->find($id)->current();
        $this->view->product = $product;
        
        $fields = array(
            'session' => session_id(),
            'productId' => $id,
        );
        $basket = $basketModel->getOneByFields($fields);
        
        $basketForm = new Application_Form_Basket();
        $values = array(
            'quantity' => $basket['quantity'],
            'productId' => $product['productId'],
        );
        $basketForm->populate($values);
        $this->view->basketForm = $basketForm;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            $data = array(
                'productId' => $postParams['productId'],
                'quantity' => $postParams['quantity'],
            );
            $this->addToBasket($data);
        }
    }
    
    public function basketAction()
    {
        $productId = $this->_getParam('id');
        
        $data = array('productId' => $productId);
        $this->addToBasket($data);
        
    }
    
    public function addToBasket($data) {
        $basketModel = new Application_Model_Basket();
        $userModel = new Application_Model_User();
                
        $quantity = isset($data['quantity']) ? $data['quantity'] : 1;

        $userId = $userModel->getUserId();
        
        if($userId) {
            //check winkelmand met userId
            $fields = array(
                'session' => session_id(),
                'userId' => $userId,
                'productId' => $data['productId'],
            );
            
            $basket = $basketModel->getOneByFields($fields);
        } else {
            //check winkelmand met sessionId
            $fields = array(
                'session' => session_id(),
                'userId' => null,
                'productId' => $data['productId'],
            );
            $basket = $basketModel->getOneByFields($fields);
        }
        
        if($basket) {
            $quantity = $basket['quantity'] + $quantity;
            $params = array(
                'quantity' => $quantity,
            );
            //Zend_Debug::dump($basket);exit;
            $basketModel->updateById($params, $basket['basketId']);
        } else {
            $params = array(
                'productId' => $data['productId'],
                'userId' => $userId,
                'session' => session_id(),
                'quantity' => $quantity,
            );
            $basketModel->insert($params, false);
        }
        $this->view->basket=$basketModel->getBasket();
    }
    
    public function highlightAction() {
        $productModel = new Application_Model_Product();
        $where = 'highlight=1';
        $this->view->products = $productModel->getAll($where);
    }
    
}

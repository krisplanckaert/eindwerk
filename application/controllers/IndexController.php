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
        
        $userId = $this->getUserId();
        $this->getBasket($userId);

        $this->view->categories = $categoryModel->getAllCategories();
    }

    public function detailAction()
    {
        $id = $this->_getParam('id');
        
        $productModel = new Application_Model_Product();
        $winkelmandModel = new Application_Model_Winkelmand();
        $product = $productModel->find($id)->current();
        $this->view->product = $product;
        
        $fields = array(
            'session' => session_id(),
            'id_product' => $id,
        );
        $winkelmand = $winkelmandModel->getOneByFields($fields);
        
        $winkelmandForm = new Application_Form_Winkelmand();
        $values = array(
            'aantal' => $winkelmand['aantal'],
            'ID_Product' => $product['id'],
        );
        $winkelmandForm->populate($values);
        $this->view->winkelmandForm = $winkelmandForm;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            //Zend_Debug::dump($postParams);exit;
            $data = array(
                'product_id' => $postParams['ID_Product'],
                'Aantal' => $postParams['aantal'],
            );
            $this->toevoegenAanWinkelmand($data);
        }
    }
    
    public function mandAction()
    {
        $product_id = $this->_getParam('id');
        
        $data = array('product_id' => $product_id);
        $this->toevoegenAanWinkelmand($data);
        
    }
    
    public function toevoegenAanWinkelmand($data) {
        $basketModel = new Application_Model_Basket();
                
        $quantity = isset($data['quantity']) ? $data['quantity'] : 1;

        $userId = $this->getUserId();
        
        if($userId) {
            //check winkelmand met userId
            $basket = $basketModel->getOneByField('userId', $userId);
        } else {
            //check winkelmand met sessionId
            $fields = array(
                'session' => session_id(),
                'userId' => null,
            );
            $basket = $basketModel->getOneByFields($fields);
        }
        
        if($basket) {
            $quantity = $basket['quantity'] + $quantity;
            $params = array(
                'quantity' => $quantity,
            );
            $basketModel->wijzigen($params, $basket['id']);
        } else {
            $params = array(
                'productId' => $data['productId'],
                'userId' => $userId,
                'session' => session_id(),
                'quantity' => $quantity,
            );
            $basketModel->toevoegen($params);
        }
        
        $this->getBasket($userId);
    }
    
    public function getBasket($userId) {
        $basketModel = new Application_Model_Basket();
        if($userId) {
            $where = 'userId='.$userId;
        } else {
            $where = 'session="'.session_id().'" and userId is null';
        }
        $this->view->basket = $basketModel->getAll($where);
    }
    
    public function getUserId() {
        $userModel = new Application_Model_User();
        $userId = null;
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $username = $auth->getIdentity();
            $user = $userModel->getOneByField('name', $username);
            $userId = $user ? $user['userId'] : null;
        } 
        return $userId;
    }
}

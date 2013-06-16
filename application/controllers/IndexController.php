<?php

class IndexController extends My_Controller_Action
{

    public function init()
    {
        $this->authUser = (array)Zend_Auth::getInstance()->getIdentity();
        if($this->authUser) {
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();
        }
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
            $basketModel->insert($params);
        }
        $this->view->basket=$basketModel->getBasket();
    }
    
    public function highlightAction() {
        $productModel = new Application_Model_Product();
        $where = 'highlight=1';
        $this->view->products = $productModel->getAll($where);
    }
    
    public function searchAction()
    {
        $locale = Zend_Registry::get('Zend_Locale');
        $productModel = new Application_Model_Product();
        $form = new Application_Form_Search();
        if($this->getRequest()->getPost()) {
            $postParams = $this->getRequest()->getPost();
            if($form->isValid($postParams)) {
                $this->view->products = $productModel->getAllByDescription($locale, $postParams);
            }
        }
    }
    
    public function loginAction()
    {
        $form = new Application_Form_Signup();
        if($this->getRequest()->getPost()) {
            $postParams = $this->getRequest()->getPost();
            if(isset($postParams['login'])) {
                if($form->isValid($postParams)) {
                    $this->login($postParams);
                } 
            }
            if(isset($postParams['register'])) {
                $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'register')));
            }
        }

    }
    
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'index')));
    }
    
    public function registerAction()
    {
        $this->view->form = new Application_Form_User();
        if($this->getRequest()->getPost()) {
            $postParams = $this->getRequest()->getPost();
            unset($postParams['add']);
            unset($postParams['repeatPassword']);
            $postParams['roleId']=2;
            $userModel = new Application_Model_User();
            $userId = $userModel->save($postParams);
            if($userId) {
                $this->login($postParams, 'order');
             }
        }
    }
    
    public function login($postParams, $action='index') {
        $auth = Zend_Auth::getInstance();
        //meegeven welke database driver we gebruiken, is optioneel omdat we er momenteel maar 1 hebben
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'));
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('name')
                    ->setCredentialColumn('password')
                    ->setIdentity($postParams['name'])
                    ->setCredential(md5($postParams['password']));
        //login uitvoeren
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()) {
            //Alle artikels die in de winkelmand zitten linken aan die gebruiker
            $basketModel = new Application_Model_Basket();
            $basketModel->linkUser();
            $userModel = new Application_Model_User();
            $this->authUser = (array)Zend_Auth::getInstance()->getIdentity();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser);
            $localeModel = new Application_Model_Locale();
            $locale = $localeModel->getOne($this->authUserRow['localeId']);
            $basketModel = new Application_Model_Basket();
            $basket = $basketModel->getAll('userId='.$this->authUserRow['userId']);
            $action = !$basket ? 'index' : $action;
            $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> $action, 'lang' => $locale['locale'])));
            //echo 'U bent ingelogd!';
        } else {
            //alle foutmeldingen weergeven op het scherm
            $this->view->messages = $result->getMessages();
        }        
    }
        
    public function orderAction() {
        $form = new Application_Form_Order();
        $this->view->form = $form;
        $orderId = null;
        if($this->getRequest()->getPost()) {
            $postParams = $this->getRequest()->getPost();
            if($form->isValid($postParams)) {
                if(isset($postParams['reference'])) {
                    $postParams['userId'] = $this->authUserRow['userId'];
                    unset($postParams['order']);
                    $orderModel = new Application_Model_Order();
                    $orderId = $orderModel->createOrder($postParams);
                    if($orderId) {
                        $this->view->orderData = $postParams;
                    }   
                } else {
                    $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'register')));
                }
            }
        } 
        $this->view->orderId = $orderId;
    }
}

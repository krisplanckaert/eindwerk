<?php

class IndexController extends My_Controller_Action
{

    public function init()
    {
        $this->mail = new My_Controller_Plugin_Mail();
        
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
            $products = $productModel->getProductsByCategory($categoryId);
            $products = $productModel->getPhotos($products, true);
            $this->view->products = $productModel->getLocale($products, true);
        } else {
            $this->view->products = null;
        }
        
        $this->view->categories = $categoryModel->getAllCategories();
    }

    public function detailAction($options = NULL)
    {
        $id = $this->_getParam('id');
        
        $productModel = new Application_Model_Product();
        $basketModel = new Application_Model_Basket();
        $product = $productModel->find($id)->current()->toArray();
        $product = $productModel->getPhotos($product);        
        $this->view->product = $productModel->getLocale($product);
        
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
            $basketModel->addToBasket($data);
        }
        $this->view->basket=$basketModel->getBasket();        
    }
    
    
    public function highlightAction() 
    {
        $productModel = new Application_Model_Product();
        $where = 'highlight=1';
        $products = $productModel->getAll($where);
        $products = $productModel->getPhotos($products, true);        
        $this->view->products = $productModel->getLocale($products, true);
    }
    
    public function searchAction()
    {
        $locale = Zend_Registry::get('Zend_Locale');
        $productModel = new Application_Model_Product();
        $form = new Application_Form_Search();
        if($this->getRequest()->getPost()) {
            $postParams = $this->getRequest()->getPost();
            if($form->isValid($postParams)) {
                $products = $productModel->getAllByDescription($locale, $postParams);
                $products = $productModel->getPhotos($products, true);                
                $this->view->products = $productModel->getLocale($products, true);
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
            $basket = $basketModel->getAll('userId='.$this->authUserRow['userId']);
            $action = !$basket ? 'index' : $action;
            $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> $action, 'lang' => $locale['locale'])));
            } else {
            //alle foutmeldingen weergeven op het scherm
            $this->view->messages = $result->getMessages();
        }        
    }
        
    public function orderAction() {
        $redirect = $this->_getParam('redirect',null);
        $form = new Application_Form_Order();
        $this->view->form = $form;
        $orderId = null;
        if($this->getRequest()->getPost() and !$redirect) {
            $postParams = $this->getRequest()->getPost();
            if(isset($postParams['orderstart'])) {
                $this->_redirect($this->view->url(array('controller'=> 'index', 'action'=> 'order', 'redirect' => true)));
            } else {
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
        } 
        $this->view->orderId = $orderId;
    }
    
    public function lostpasswordAction() {
        $this->view->form = new Application_Form_Lostpassword();
        if (!$this->getRequest()->isPost()) {
            $this->view->data = $this->getRequest()->getParams();
            return;
        }
        $data =  $this->_request->getPost();
        if (empty($data['email'])){
            return;
        }
        $userModel = new Application_Model_User();
        $userRow   = $data = $userModel->getOneByField('email',$data['email']);
        if (empty($userRow)){
            $this->view->error = 'lbl_wrongemail';
            return;
        }
        try {
            $templateName = My_Controller_Plugin_Mail::TEMPLATE_LOST_PASSWORD;
            $data['eId'] = $userModel->saveIdentifier($userRow['userId']);
            $data['email'] = $userRow['email'];
            $data['url']   = '/index/reset/eId/' . $data['eId'];
            $this->mail->send($templateName,$data);
            $this->_redirect('/index/index');
        } catch (Exception $e){
            throw $e;
        }
    }
    
    public function resetAction(){
        $this->view->form = new Application_Form_Reset();
        
    	$data = $this->getRequest()->getParams();
    	$save = false;

        $eId = $this->getRequest()->getParam('eId');
    	
    	if ($this->getRequest()->isPost()) {    	  
    	    //submit
    	    $data =  $this->_request->getPost();
    	    $save = true;   
    	}
    	$this->view->data = $data;
    	$userModel = new Application_Model_User();
    	$userRow   = $userModel->getOneByField('eId',(string)$eId);
    	if (empty($userRow)){ 
    	    $url = '/' . $this->getRequest()->getControllerName().'/reset/eId/'.$eId.'/err/3';
    	    $this->_redirect($url);    	    
            return;
    	}
    	$this->view->user = $userRow;
    	if (!$save){
    		return;
    	}
        if (empty($data['password1'])){
            $url = '/' . $this->getRequest()->getControllerName().'/reset/eId/'.$eId.'/err/1';
            $this->_redirect($url);
            return;
        }
        if ($data['password1'] !==$data['password2']){
            $url = '/' . $this->getRequest()->getControllerName().'/reset/eId/'.$eId.'/err/2';
            $this->_redirect($url);
            $this->_helper->redirector('reset',$this->getRequest()->getControllerName(),false,array('eId' => $eId,'err' => 2));
            return;
        }
    	//save new password
        try{
            $dbFields = array(
                                    'eId' => null,
                                    'password' => md5($data['password1']),
            );
            $userModel->updateById($dbFields,$userRow['userId']);
            $this->_helper->redirector('index',$this->getRequest()->getControllerName(),false,array('msg' => 1));
        }
        catch (Exception $e){
            $url = '/' . $this->getRequest()->getControllerName().'/reset/eId/'.$eId.'/err/3';
            $this->_redirect($url);
        }
    }
    
    public function myprofileAction(){
        $this->view->form = new Application_Form_Myprofile();
    }
}

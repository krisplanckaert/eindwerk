<?php

class Admin_MenuController extends My_Controller_Action
{

    public function init()
    {
        $this->model = new Application_Model_Menu();
        parent::init();
        
    }

    public function indexAction()
    {
        // action body
        $menuModel = new Application_Model_Menu();
        $menus = $menuModel->getAll();
        $menus = $menuModel->getLocale($menus);
        $this->view->menus = $menus;
    }
    
    public function changeAction()
    {
        $menuId = (int) $this->_getParam('menuId'); //$_GET['id];

        $menuModel = new Application_Model_Menu();
        $menu = $menuModel->find($menuId)->current(); 
               
        $form = new Admin_Form_Menu($menuId);
        $menuArr = $menu->toArray();
        $menuArr = $menuModel->getLocales($menuArr);

        $menuRoleModel = new Application_Model_Menurole();
        $where = 'menuId='.$menuId;
        $menuRoles = $menuRoleModel->getAll($where);
        foreach($menuRoles as $menuRole) {
            $menuArr['rolesId'][] = $menuRole['roleId'];
        }
        //Zend_Debug::dump($menuArr);
                
        $this->view->form = $form;
        $this->view->form->populate((array)$menuArr);
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                //Zend_Debug::dump($postParams);exit;
                $this->toevoegenMenuRoles($postParams, $menuId);                
                //Zend_Debug::dump($postParams);exit;
                unset($postParams['rolesId']);
                $menuModel->save($postParams, $menuId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'list')));
            }  
        }
    }

    public function toevoegenAction()
    {
        $form  = new Admin_Form_Menu;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $menuModel = new Application_Model_Menu();
                $menuModel->toevoegen($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'index')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $menuModel = new Application_Model_Menu();
        $menuModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'index')));
    }

    public function toevoegenMenuRoles($postParams, $menuId) {
        $menuRolesModel = new Application_Model_Menurole();
        //Zend_Debug::dump($postParams);exit;
        $where = 'menuId='.$menuId;
        $menuRoles = $menuRolesModel->getAll($where);
        foreach($menuRoles as $menuRole) {
            if(!isset($postParams['rolesId']) || !in_array($menuRole['roleId'], $postParams['rolesId'])) {
                $where = 'menuId='.$menuId.' and roleId='.$menuRole['roleId'];
                $menuRolesModel->delete($where);
            }
        }
        if(isset($postParams['rolesId'])) {
            foreach($postParams['rolesId'] as $roleId) {
                Zend_Debug::dump($roleId);
                $fields = array(
                    'menuId' => $menuId,
                    'roleId' => $roleId,
                );
                $menuRole = $menuRolesModel->getOneByFields($fields);
                if(!$menuRole) {
                    $data = array(
                        'menuId' => $menuId,
                        'roleId' => $roleId,
                    );
                    $menuRolesModel->insert($data);
                } 
            }
        }
    }

    public function listAction() {
       $this->view->rows = $this->model->getAll();
       
    }
}








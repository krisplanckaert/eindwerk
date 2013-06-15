<?php

class Admin_MenuController extends My_Controller_Action
{



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
                $this->toevoegenMenuRoles($postParams, $menuId);                
                unset($postParams['rolesId']);
                $menuModel->save($postParams, $menuId);
//exit;                
                $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'list')));
            }  
        }
    }

    public function addAction()
    {
        $form  = new Admin_Form_Menu;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                unset($postParams['toevoegen']);
                $saveData = $postParams;
                unset($saveData['rolesId']);
                $menuModel = new Application_Model_Menu();
                //Zend_Debug::dump($saveData);exit;
                $menuId = $menuModel->save($saveData);
                
                $this->toevoegenMenuRoles($postParams, $menuId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $menuId = (int) $this->_getParam('menuId'); 
        $menuModel = new Application_Model_Menu();
        $menuModel->delete('menuId='.$menuId);
        $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'list')));
    }

    public function toevoegenMenuRoles($postParams, $menuId) {
        $menuRolesModel = new Application_Model_Menurole();
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


}








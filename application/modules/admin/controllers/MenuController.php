<?php

class Admin_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */        
        
    }

    public function indexAction()
    {
        // action body
        $menuModel = new Application_Model_Menu();
        $this->view->menus= $menuModel->getAll()->toArray();
    }
    
    public function wijzigenAction()
    {
        $id = (int) $this->_getParam('id'); //$_GET['id];
                
        $menuModel = new Application_Model_Menu();
        $menu = $menuModel->find($id)->current(); 
               
        $form = new Admin_Form_Menu($id);
        $menuArr = $menu->toArray();
        //$menuArr['ID_Roles'] = array('1', '2');
        $menuRoleModel = new Application_Model_Menurole();
        $where = 'id_menu='.$id;
        $menuRoles = $menuRoleModel->getAll($where);
        foreach($menuRoles as $menuRole) {
            $menuArr['ID_Roles'][] = $menuRole['id_role'];
        }
        $form->populate($menuArr);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            //Zend_Debug::dump($postParams);exit;
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                
                $this->toevoegenMenuRoles($postParams, $id);

                unset($postParams['ID_Roles']);
                $menuModel->wijzigen($postParams, $id);
                
                /*$this->_redirect('/menu/index');*/
                
                $this->_redirect($this->view->url(array('controller'=> 'Menu', 'action'=> 'index')));
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

    public function toevoegenMenuRoles($postParams, $id_menu) {
        $menuRolesModel = new Application_Model_Menurole();
        //Zend_Debug::dump($postParams);exit;
        $where = 'id_menu='.$id_menu;
        $menuRoles = $menuRolesModel->getAll($where);
        foreach($menuRoles as $menuRole) {
            if(!in_array($menuRole['id_role'], $postParams['ID_Roles'])) {
                $where = 'id_menu='.$id_menu.' and id_role='.$menuRole['id_role'];
                $menuRolesModel->delete($where);
            }
        }
        
        foreach($postParams['ID_Roles'] as $id_role) {
            $fields = array(
                'id_menu' => $id_menu,
                'id_role' => $id_role,
            );
            $menuRole = $menuRolesModel->getOneByFields($fields);
            if(!$menuRole) {
                $data = array(
                    'id_menu' => $id_menu,
                    'id_role' => $id_role,
                );
                $menuRolesModel->insert($data);
            }
        }
    }
}








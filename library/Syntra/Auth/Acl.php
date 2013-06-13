<?php

class Syntra_Auth_Acl extends Zend_Controller_Plugin_Abstract 
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request) 
    {
        $acl = new Zend_Acl();
        $roles = array('GUEST', 'USER', 'ADMIN');
        $controllers = array('user' , 'index' ,'page', 'error', 'admin-index', 'admin-user', 'noaccess', 'admin');

        foreach($roles as $role) {
            $acl->addRole($role); 
        }

        foreach($controllers as $controller) {
            //$acl->addResource($controller); -> nieuwe manier
            $acl->add(new Zend_Acl_Resource($controller));
        }
        $acl->allow('ADMIN'); //acces to everything
        $acl->allow('USER');  //acces to everything
        $acl->deny('USER', 'admin-index'); //normal user has no access to admin index    
        $acl->deny('USER', 'admin-user'); //normal user has no access to admin index    
        
        /*$acl->deny('USER');  //deny everything
        $acl->allow('USER', 'page');
        $acl->allow('USER', 'error');
        $acl->allow('USER', 'user');
        $acl->allow('USER', 'noaccess');*/
        
        Zend_Registry::set('Zend_Acl', $acl);
    }
}

?>

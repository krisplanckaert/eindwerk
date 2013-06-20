<?php

class Syntra_Auth_Acl extends Zend_Controller_Plugin_Abstract 
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request) 
    {
        $acl = new Zend_Acl();
        $roles = array('GUEST', 'USER', 'DEALER', 'ADMIN');
        $controllers = array(
            'user' , 'index' , 'page', 'error', 'noaccess', 'admin',
            'admin-menu', 
            'dealer-category', 'dealer-page', 'dealer-photo', 'dealer-product', 'dealer-user', 
            'user-order', 'user-orderdetail', 
            );
        foreach($roles as $role) {
            $acl->addRole($role); 
        }

        foreach($controllers as $controller) {
            //$acl->addResource($controller); -> nieuwe manier
            $acl->add(new Zend_Acl_Resource($controller));
        }

        $acl->allow('ADMIN'); //acces to everything

        $acl->allow('DEALER');  //acces to everything
        $acl->deny('DEALER', 'admin-menu');

        $acl->allow('USER');  //acces to everything
        $acl->deny('USER', 'admin-menu');
        $acl->deny('USER', 'dealer-category');
        $acl->deny('USER', 'dealer-page');
        $acl->deny('USER', 'dealer-photo');
        $acl->deny('USER', 'dealer-product');
        $acl->deny('USER', 'dealer-user');

        $acl->allow('GUEST');  //acces to everything
        $acl->deny('GUEST', 'admin-menu');
        $acl->deny('GUEST', 'dealer-category');
        $acl->deny('GUEST', 'dealer-page');
        $acl->deny('GUEST', 'dealer-photo');
        $acl->deny('GUEST', 'dealer-product');
        $acl->deny('GUEST', 'dealer-user');
        $acl->deny('GUEST', 'user-order');
        $acl->deny('GUEST', 'user-orderdetail');

        
        Zend_Registry::set('Zend_Acl', $acl);
    }
}

?>

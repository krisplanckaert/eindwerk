<?php
class Syntra_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    /**
*
* @param \Zend_Controller_Request_Abstract $request
* @return \Zend_Navigation
*/
    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        
        // make navigation
        $container = new Zend_Navigation();
        $menuroleModel = new Application_Model_Menurole();
        $userModel = new Application_Model_User();
        
        $locale = Zend_Registry::get('Zend_Locale');
        //Zend_Debug::dump($locale);exit;
        
        $roleId = 1;
        $auth = Zend_Auth::getInstance();
        $userName = $auth->getIdentity();
        $fields = array(
            'name' => $userName,
        );
        $user = $userModel->getOneByFields($fields);
        if($user) {
            $roleId = $user['roleId'];
        }
        $menus = $menuroleModel->getMenuByRole($roleId, $locale);
        foreach($menus as $menu) {
            $page = new Zend_Navigation_Page_Mvc(array(
               'label' => $menu['label'],
               'action' => $menu['action'],
               'controller' => $menu['controller'],
               'module' => $menu['module'],
               'params' => array('slug' => $menu['slug'],
                                 'lang' => $locale)
            ));
            $container->addPage($page);     
        }
        
        Zend_registry::set('Zend_Navigation' ,$container);
        return $container;
                
    }
}

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
        //Zend_Debug::dump($menus);
        foreach($menus as $menu) {
            $page = new Zend_Navigation_Page_Mvc(array(
               'label' => $menu['description'],
               'action' => $menu['action'],
               'controller' => $menu['controller'],
               'module' => $menu['module'],
               'params' => array('slug' => $menu['slug'],
                                 'lang' => $locale)
            ));
            $container->addPage($page);     
        }
        
        $pageModel = new Application_Model_Page();
        $pages = $pageModel->getAllPages();
        foreach($pages as $page) {
            //Zend_Debug::dump($page);exit;
            $page = new Zend_Navigation_Page_Mvc(array(
               'label' => $page['locale']['title'],
               'action' => 'index',
               'controller' => 'page',
               'module' => 'default',
               'params' => array('slug' => $page['slug'],
                                 'lang' => $locale)
            ));
            //Zend_Debug::dump($page);exit;
            $container->addPage($page);  
        }
            
        Zend_registry::set('Zend_Navigation' ,$container);
        
        return $container;
                
    }
}

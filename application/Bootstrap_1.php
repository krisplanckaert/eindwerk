<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initMyActionHelpers()
    {
        $this->bootstrap('frontController');
        $signup = Zend_Controller_Action_HelperBroker::getStaticHelper('Signup');
        Zend_Controller_Action_HelperBroker::addHelper($signup);
        $search = Zend_Controller_Action_HelperBroker::getStaticHelper('Search');
        Zend_Controller_Action_HelperBroker::addHelper($search);
        $orderstart = Zend_Controller_Action_HelperBroker::getStaticHelper('Orderstart');
        Zend_Controller_Action_HelperBroker::addHelper($orderstart);
        
    }

    protected function _initRegisterControllerPlugins() 
    {
        //$this->bootstrap('frontController');        
        $front = $this->getResource('frontcontroller');
        
        //setup the layout
        Zend_Layout::startMvc(array(
            'layoutPath' => '../application/layouts/scripts',
            'layout' => 'layout',
        ));

        $front->registerPlugin(new Syntra_Controller_Plugin_Translate());    
        $front->registerPlugin(new Syntra_Controller_Plugin_Navigation());
        $front->registerPlugin(new Syntra_Auth_Acl());
        $front->registerPlugin(new Syntra_Auth_Auth());

        $layoutModulePlugin = new Syntra_Controller_Plugin_Layout();
        $layoutModulePlugin->registerModuleLayout('admin','../application/modules/admin/layouts/scripts','layout');
        $front->registerPlugin($layoutModulePlugin);
    }    
    
    public function _initDbAdapter() 
    {
        $this->bootstrap('db');    
        $db = $this->getResource('db');
        
        Zend_Registry::set('db',$db);
        //Ophalen dmv Zend_Registry::get('db');
    }
    
    /*public function _initRouter(array $options=NULL)
    {    
        $router = $this->getResource('frontcontroller')->getRouter();
        //add custom route
        // : before param = get variabele
        $router->addRoute('noaccess', 
            new Zend_Controller_Router_Route('/noaccess', array(
                'controller' => 'noaccess',
                'action'     => 'index',
            )));   
        
        //add custom route
        // : before param = get variabele
        $router->addRoute('logout', 
            new Zend_Controller_Router_Route('/logout', array(
                'controller' => 'user',
                'action'     => 'logout',
            )));
        // : before param = get variabele
        $router->addRoute('page', 
            new Zend_Controller_Router_Route('/:lang/:slug/pagina', array(
                'controller' => 'page',
                'action'     => 'index',
            )));
        // : before param = get variabele
        $router->addRoute('home', 
            new Zend_Controller_Router_Route('/:lang', array(
                'controller' => 'index',
                'action'     => 'index',
            )));
    }*/
    protected function _initView()
    {
        $view = new Zend_View();
        ZendX_JQuery::enableView($view);	
        $jqueryTheme = 'smoothness';
        $view->jQuery()->setLocalPath('/base/js/jquery/jquery.min.js')
                       ->setUiLocalPath('/base/js/jquery/jquery-ui.min.js')                                   
//				   ->addStyleSheet('/base/js/jquery/css/'.$jqueryTheme.'/jquery.ui.all.css')		                   
                       ->addStyleSheet('/base/js/jquery/css/'.$jqueryTheme.'/jquery-ui.custom.css')
                       ;

        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
                       return $view;
    }

}


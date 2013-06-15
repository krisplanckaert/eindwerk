<?php

class Dealer_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initTest() {
        //die('admin init test');
    }
    
    protected function _initView()
    {
            $options = $this->getOptions(); // get contents of application.ini 
            if (isset($options['resources']['view'])) {
                $view = new Zend_View($options['resources']['view']);
            } else {
                $view = new Zend_View();
            }
            if (isset($options['resources']['view']['doctype'])) {
                $view->doctype($options['resources']['view']['doctype']);
            }
            if (isset($options['resources']['view']['contentType'])) {
                $view->headMeta()->appendHttpEquiv('Content-Type',
                $options['resources']['view']['contentType']);
            }

            $view->headTitle("Dealer");
            ZendX_JQuery::enableView($view);	
            $jqueryTheme = 'smoothness';
            $view->jQuery()->setLocalPath('/base/js/jquery/jquery.min.js')
                            ->setUiLocalPath('/base/js/jquery/jquery-ui.min.js')                                   
                            ->addStyleSheet('/base/js/jquery/css/'.$jqueryTheme.'/jquery-ui.custom.css')
            ;

            $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
            $viewRenderer->setView($view);
            Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
            //view helpers
            $view->addHelperPath(APPLICATION_PATH . '/views/helpers');
            $view->addHelperPath('ZendX/JZendXQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
            $view->addHelperPath('My/View/Helper/', 'My_View_Helper');		
            return $view; 		
    } 
    
}

?>

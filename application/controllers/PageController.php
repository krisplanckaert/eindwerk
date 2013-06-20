<?php

class PageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $locale = Zend_Registry::get('Zend_Locale');
        $slug = $this->_getParam('slug');

        $pageModel = new Application_Model_Page();

        $page = $pageModel->getPage($locale, $slug);
        $this->view->page = $page;

    }
    


    
    
}

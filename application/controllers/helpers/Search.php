<?php

class Application_Controller_Helper_Search extends Zend_Controller_Action_Helper_Abstract
{
    public function preDispatch()
    {
        $view = $this->getActionController()->view;
        $form = new Application_Form_Search();

        $view->searchForm = $form;
        
    }
}

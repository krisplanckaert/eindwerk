<?php
class Zend_View_Helper_SearchForm extends Zend_View_Helper_Abstract
{
    public function searchForm(Application_Form_Search $form)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        $html = $form->render();

        return $html;

    }

}
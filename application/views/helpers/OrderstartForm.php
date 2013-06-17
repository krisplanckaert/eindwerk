<?php
class Zend_View_Helper_OrderstartForm extends Zend_View_Helper_Abstract
{
    public function orderstartForm(Application_Form_Orderstart $form)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        $html = $form->render();

        return $html;


    }

}
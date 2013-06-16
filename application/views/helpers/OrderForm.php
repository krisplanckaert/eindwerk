<?php
class Zend_View_Helper_OrderForm extends Zend_View_Helper_Abstract
{
    public function orderForm(Application_Form_Order $form)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        $html = $form->render();

        return $html;


    }

}
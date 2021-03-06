<?php

class Application_Form_Order extends My_Form 
{
   
    public function init($options = null)
    {
        parent::init();
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/order');
            
        $this->addElement(new Zend_Form_Element_Text('reference',array(
            'label'=>"Reference",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('order', array(
            'type'=>"submit",
            'value'=>'Order',
            'required'=> false,
            'ignore'=> true
            )));
    }
}

?>

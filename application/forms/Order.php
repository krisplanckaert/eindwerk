<?php

class Application_Form_Order extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/order');
            
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

<?php

class Application_Form_Orderstart extends My_Form {
   
    public function init($options = null){
        parent::init();
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/order');
            
         // element button
        $this->addElement(new Zend_Form_Element_Button('orderstart', array(
            'type'=>"submit",
            'label'=>'Order',
            'required'=> false,
            'ignore'=> true
            )));
    }
}

?>

<?php

class User_Form_Order extends My_Form {
   
    public function init($options = null){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        $this->addElement(new Zend_Form_Element_Text('orderId',array('hidden'=>true)));
        
        $this->addElement(new Zend_Form_Element_Text('userId',array(
            'label'=>"User ID",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('lbl_add', array(
            'type'=>"submit",
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

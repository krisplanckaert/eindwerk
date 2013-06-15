<?php

class User_Form_Order extends My_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('orderId',array('hidden'=>true)));
        
        $this->addElement(new Zend_Form_Element_Text('userId',array(
            'label'=>"User ID",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('toevoegen', array(
            'type'=>"submit",
            'value'=>'Toevoegen',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

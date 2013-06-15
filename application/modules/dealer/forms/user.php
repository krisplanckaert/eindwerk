<?php

class Admin_Form_User extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element naam
        $this->addElement(new Zend_Form_Element_Text('name',array(
            'label'=>"Name",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        // element wachtwoord
        $this->addElement(new Zend_Form_Element_Text('password',array(
            'label'=>"Password",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('add', array(
            'type'=>"submit",
            'value'=>'Add',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

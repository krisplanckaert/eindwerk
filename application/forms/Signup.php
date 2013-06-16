<?php

class Application_Form_Signup extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/login');
        
        // element naam
        $this->addElement(new Zend_Form_Element_Text('name',array(
            'label'=>"lbl_Naam",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        // element wachtwoord
        $this->addElement(new Zend_Form_Element_Password('password',array(
            'label'=>"lbl_Wachtwoord",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('login', array(
            'type'=>"submit",
            'value'=>'login',
            'required'=> false,
            'ignore'=> true
            )));
        
        // element button
        $this->addElement(new Zend_Form_Element_Button('register', array(
            'type'=>"submit",
            'value'=>'Register',
            'required'=> false,
            'ignore'=> true
            )));
    }
    
}

?>

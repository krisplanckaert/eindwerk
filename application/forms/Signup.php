<?php

class Application_Form_Signup extends Zend_Form {
   
    public function init($options = null)
    {
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/login');
        
        $this->addElement(new Zend_Form_Element_Text('name',array(
            'label'=>"lbl_Naam",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Password('password',array(
            'label'=>"lbl_Wachtwoord",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Button('login', array(
            'type'=>"submit",
            'label' => 'lbl_login',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
}

?>

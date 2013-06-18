<?php

class Application_Form_Myprofile extends My_Form {
   
    public function init($options = null){
        parent::init();
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        $this->addElement(new Zend_Form_Element_Text('email',array(
            'label'=>"Email",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Password('password',array(
            'label'=>"Password",
            'filters' => array('StringTrim')
            )));
        
        $password2 = new Zend_Form_Element_Password('repeatPassword');
        $password2->setLabel('Confirm password')
                       ->addFilter('StringTrim')
                       ->addFilter('StripTags')
                       ->addValidator('NotEmpty')
                       ->addValidator(new My_Validate_IdenticalField('password'), FALSE)
                       ->setValue('');
                    ;     
        $this->addElement($password2);
        
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

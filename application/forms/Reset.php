<?php

class Application_Form_Reset extends Zend_Form 
{
   
    public function init($options = null)
    {
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element naam
        $this->addElement(new Zend_Form_Element_Password('password1',array(
            'label'=>"lbl_passwordnew",
            'required'=>true,
            'filters' => array('StringTrim')
            )));

        // element naam
        $this->addElement(new Zend_Form_Element_Password('password2',array(
            'label'=>"lbl_passwordnewconfirm",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('continue', array(
            'type'=>"submit",
            'label' => 'lbl_continue',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
}

?>

<?php

class Application_Form_Lostpassword extends Zend_Form 
{
   
    public function init($options = null)
    {
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element naam
        $this->addElement(new Zend_Form_Element_Text('email',array(
            'label'=>"lbl_email",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('send', array(
            'type'=>"submit",
            'label' => 'lbl_send',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
}

?>

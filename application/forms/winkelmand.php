<?php

class Application_Form_Winkelmand extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element aantal
        $this->addElement(new Zend_Form_Element_Text('aantal',array(
            'label'=>"Aantal",
            'required'=>true,
            // filters
            'filters' => array('Int')
            )));

        // element ID_Product
        $this->addElement(new Zend_Form_Element_Hidden('ID_Product',array()));
        
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

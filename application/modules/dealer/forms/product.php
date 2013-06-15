<?php

class Dealer_Form_Product extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        $this->addElement(new Zend_Form_Element_Text('label',array(
            'label'=>"Label",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        $this->addElement(new Zend_Form_Element_Text('price',array(
            'label'=>"Prijs",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        $this->addElement(new Zend_Form_Element_Checkbox('status',array(
            'label'=>"Status",
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

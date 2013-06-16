<?php

class Application_Form_Search extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        $this->setAction('/index/search');
        
        // element naam
        $this->addElement(new Zend_Form_Element_Text('description',array(
            'label'=>"Desctription",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
                
         // element button
        $this->addElement(new Zend_Form_Element_Button('search', array(
            'type'=>"submit",
            'value'=>'Search',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
}

?>

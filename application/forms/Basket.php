<?php

class Application_Form_Basket extends Zend_Form 
{
   
    public function init($options = null)
    {
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element aantal
        $this->addElement(new Zend_Form_Element_Text('quantity',array(
            'label'=>"lbl_quantity",
            'required'=>true,
            'filters' => array('Int')
            )));

        // element ID_Product
        $this->addElement(new Zend_Form_Element_Hidden('productId',array()));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('add', array(
            'type'=>"submit",
            'name'=>'lbl_add',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

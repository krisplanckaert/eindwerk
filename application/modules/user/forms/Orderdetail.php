<?php

class User_Form_Orderdetail extends My_Form {
   
    public function init($options = null){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('orderDetailId',array('hidden'=>true)));
        
        $this->addElement(new Zend_Form_Element_Text('productId',array(
            'label'=>"Product ID",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Text('quantity',array(
            'label'=>"Quantity",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Text('price',array(
            'label'=>"Price",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('lbl_add', array(
            'type'=>"submit",
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

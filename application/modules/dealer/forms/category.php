<?php

class Dealer_Form_Category extends Zend_Form {
   
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
        
        $productModel = new Application_Model_Product();
        $productList = $productModel->getProductsList();
        $products = new Zend_Form_Element_MultiCheckbox('productsId', array(
            'label' => 'Products',
        ));
        $products->setMultiOptions($productList);
        $this->addElement($products);
                        
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
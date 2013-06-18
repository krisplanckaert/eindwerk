<?php

class Dealer_Form_Page extends My_Form {
   
    public function init($options = null){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('pageId',array('hidden'=>true)));
        
        $this->addElement(new Zend_Form_Element_Text('label',array(
            'label'=>"Label",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        //locale
        $localeModel = new Application_Model_Locale();
        $locale = $localeModel->getAll();
        foreach($locale as $k => $v) {
            $this->addElement(new Zend_Form_Element_Text('description'.$v['localeId'], array(
                'label' => 'Description'.' '.$v['short'],
                'belongsto' => 'description',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
            $this->addElement(new Zend_Form_Element_Text('title'.$v['localeId'], array(
                'label' => 'title'.' '.$v['short'],
                'belongsto' => 'title',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
        }
        
        $this->addElement(new Zend_Form_Element_Text('slug',array(
            'label'=>"Slug",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
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

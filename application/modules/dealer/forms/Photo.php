<?php

class Dealer_Form_Photo extends My_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);

        // element label
        $this->addElement(new Zend_Form_Element_Text('photoId',array('hidden'=>true)));
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('label',array(
            'label'=>"Label",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('fileName',array(
            'label'=>"Filename",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
               
        //locale
        $localeModel = new Application_Model_Locale();
        $locale = $localeModel->getAll();
        foreach($locale as $k => $v) {
            $this->addElement(new Zend_Form_Element_Text('title'.$v['localeId'], array(
                'label' => 'title'.' '.$v['short'],
                'belongsto' => 'title',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
            $this->addElement(new Zend_Form_Element_Text('teaser'.$v['localeId'], array(
                'label' => 'teaser'.' '.$v['short'],
                'belongsto' => 'teaser',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
        }
        
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

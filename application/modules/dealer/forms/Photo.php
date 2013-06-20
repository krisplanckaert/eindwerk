<?php

class Dealer_Form_Photo extends My_Form {
   
    public function init($options = null){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);

        // element label
        $this->addElement(new Zend_Form_Element_Text('photoId',array('hidden'=>true)));
        
        //locale
        $localeModel = new Application_Model_Locale();
        $locale = $localeModel->getAll();
        foreach($locale as $k => $v) {
            $this->addElement(new Zend_Form_Element_Text('title'.$v['localeId'], array(
                'label' => 'title'.' '.$v['short'],
                'belongsto' => 'title',
                'filters' => array('StringTrim'),
             )));
            $this->addElement(new Zend_Form_Element_Text('teaser'.$v['localeId'], array(
                'label' => 'teaser'.' '.$v['short'],
                'belongsto' => 'teaser',
                'filters' => array('StringTrim'),
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

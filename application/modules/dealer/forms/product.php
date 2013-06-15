<?php

class Dealer_Form_Product extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('productId',array('hidden'=>true)));
        
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
        //locale
        $localeModel = new Application_Model_Locale();
        $locale = $localeModel->getAll();
        foreach($locale as $k => $v) {
            $this->addElement(new Zend_Form_Element_Text('title'.$v['localeId'], array(
                'label' => 'Title'.' '.$v['short'],
                'belongsto' => 'title',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
            $this->addElement(new Zend_Form_Element_Text('teaser'.$v['localeId'], array(
                'label' => 'Teaser'.' '.$v['short'],
                'belongsto' => 'teaser',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
            $this->addElement(new Zend_Form_Element_Text('content'.$v['localeId'], array(
                'label' => 'Content'.' '.$v['short'],
                'belongsto' => 'content',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
        }
        $photoModel = new Application_Model_Photo();
        $photoList = $photoModel->getPhotosList();
        $photos = new Zend_Form_Element_MultiCheckbox('photosId', array(
            'label' => 'Photos',
        ));
        $photos->setMultiOptions($photoList);
        $this->addElement($photos);
                        
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

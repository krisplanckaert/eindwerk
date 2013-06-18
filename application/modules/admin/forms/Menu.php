<?php

class Admin_Form_Menu extends My_Form {
   
    public function init($options = null){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);

        // element label
        $this->addElement(new Zend_Form_Element_Text('menuId',array('hidden'=>true)));
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('label',array(
            'label'=>"Label",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        // element action
        $this->addElement(new Zend_Form_Element_Text('module',array(
            'label'=>"Module",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        // element action
        $this->addElement(new Zend_Form_Element_Text('action',array(
            'label'=>"Action",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));

        // element controller
        $this->addElement(new Zend_Form_Element_Text('controller',array(
            'label'=>"Controller",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));

        //locale
        $localeModel = new Application_Model_Locale();
        $locale = $localeModel->getAll();
        foreach($locale as $k => $v) {
            $this->addElement(new Zend_Form_Element_Text($v['localeId'], array(
                'label' => 'Description'.' '.$v['short'],
                'belongsto' => 'description',
                'filters' => array('StringTrim'),
                //'validator' => 'NotEmpty',
             )));
        }
        
        // element controller
        $this->addElement(new Zend_Form_Element_Text('slug',array(
            'label'=>"Slug",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
        // element roles
        $rolesModel = new Application_Model_Role();
        $rolesList = $rolesModel->getRolesList();
        //Zend_Debug::dump($rolesList);exit;
        $roles = new Zend_Form_Element_MultiCheckbox('rolesId', array(
            'label' => 'Role',
        ));
        $roles->setMultiOptions($rolesList);
        $this->addElement($roles);
                        
            
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

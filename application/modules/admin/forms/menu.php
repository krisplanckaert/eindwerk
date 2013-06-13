<?php

class Admin_Form_Menu extends Zend_Form {
   
    public function init(){
        // set the defaults
        $this->setMethod(Zend_Form::METHOD_POST);
        //$this->setAttrib('enctype', 'multiparts/form-data');
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element label
        $this->addElement(new Zend_Form_Element_Text('label',array(
            'label'=>"Label",
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

        // element controller
        $this->addElement(new Zend_Form_Element_Text('locale',array(
            'label'=>"Locale",
            'required'=>true,
            // filters
            'filters' => array('StringTrim')
            )));
        
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
        $roles = new Zend_Form_Element_MultiCheckbox('ID_Roles', array(
            'label' => 'Role',
            'required' => true,
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

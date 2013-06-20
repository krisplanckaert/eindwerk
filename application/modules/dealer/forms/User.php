<?php

class Dealer_Form_User extends My_Form {
   
    public function init($options = null){
        // set the defaults
        parent::init();
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
        
        // element email
        $this->addElement(new Zend_Form_Element_Text('email',array(
            'label'=>"Email",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Password('password',array(
            'label'=>"Password",
            'filters' => array('StringTrim')
            )));
        
        $password2 = new Zend_Form_Element_Password('repeatPassword');
        $password2->setLabel('Confirm password')
                       ->addFilter('StringTrim')
                       ->addFilter('StripTags')
                       ->addValidator('NotEmpty')
                       ->addValidator(new My_Validate_IdenticalField('password'), FALSE)
                       ->setValue('');
                    ;     
        $this->addElement($password2);
        
        if($this->authUserRow['roleId']>2) {
            // element roles
            $rolesModel = new Application_Model_Role();
            $rolesList = $rolesModel->getRolesList();
            if($this->authUserRow['roleId']<>4) {
                unset($rolesList[4]);
            }
            $roles = new Zend_Form_Element_Radio('roleId', array(
                'label' => 'Role',
            ));
            $roles->setMultiOptions($rolesList);
            $this->addElement($roles);
        } 
        
         // element button
        $this->addElement(new Zend_Form_Element_Button('add', array(
            'type'=>"submit",
            'value'=>'Add',
            'required'=> false,
            'ignore'=> true
            )));
        
    }
    
       
        
}

?>

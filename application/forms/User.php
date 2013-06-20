<?php

class Application_Form_User extends My_Form 
{
   
    public function init($options = null)
    {
        // set the defaults
        parent::init();
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setAttrib('enctype', Zend_Form::ENCTYPE_MULTIPART);
     
        $this->addElement(new Zend_Form_Element_Text('name',array(
            'label'=>"lbl_name",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Text('email',array(
            'label'=>"lbl_email",
            'required'=>true,
            'filters' => array('StringTrim')
            )));
        
        $this->addElement(new Zend_Form_Element_Password('password',array(
            'label'=>"lbl_password",
            'filters' => array('StringTrim')
            )));
        
        $password2 = new Zend_Form_Element_Password('repeatPassword');
        $password2->setLabel('lbl_passwordconfirm')
                       ->addFilter('StringTrim')
                       ->addFilter('StripTags')
                       ->addValidator('NotEmpty')
                       ->addValidator(new My_Validate_IdenticalField('password'), FALSE)
                       ->setValue('');
                    ;     
        $this->addElement($password2);
        
        // locale
          $localeModel = new Application_Model_Locale();
          $options = array(
              'value' => 'short',
              'emptyRow' => false,
          );
          $localeList = $localeModel->buildSelect($options);
          $locale = new Zend_Form_Element_Select('localeId');
          $locale->setLabel('Language')
                ->setMultiOptions($localeList)
                ->setRequired()
                ->setFilters(array('StringTrim', 'StripTags'))
                ->addValidator('NotEmpty', TRUE)
          ;
        $this->addElement($locale);
                  
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

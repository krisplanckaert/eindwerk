<?php

class Syntra_Auth_Auth extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(\Zend_Controller_Request_Abstract $request) 
    {
        $locale          = Zend_Registry::get('Zend_Locale');
        $auth            = Zend_Auth::getInstance();
        
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');        
        
        //if user is not logged in and is not requesting the login page
        // - redirect to login page
        
        if($auth->hasIdentity()) {
            $acl = Zend_Registry::get('Zend_Acl');
            
            $identity = $auth->getIdentity();  //$identity = username
            
            $usersModel = new Application_Model_User();
            $roleModel = new Application_Model_Role();
            $user = $usersModel->getUserByIdentity($identity);
            $role = $roleModel->getOne($user->roleId);
            $resource = $request->getModuleName().'-'.$request->getControllerName();
            if($acl->has($resource)) {
                //role is een veld binnen onze user tabel
                $isAllowed = $acl->isAllowed($role['role'],  // -> role, moet uit Db komen
                                $resource,
                                $request->getActionName());
                if(!$isAllowed) {
                    $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                    $redirector->gotoUrl('/noaccess');
                }
            }
        } 
    }
}

?>

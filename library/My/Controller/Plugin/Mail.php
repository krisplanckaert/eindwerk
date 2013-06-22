<?php
/**
* Setup view variables
*/
class My_Controller_Plugin_Mail extends Zend_Controller_Plugin_Abstract
{
    // -----------------------------------------------
    // Set all available mail templates as constants
    // -----------------------------------------------
    	const TEMPLATE_LOST_PASSWORD  = 'lostPassword';
    
     public $view;
    

     public function __construct()
     {
     	$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
     	$viewRenderer->init();
     	$this->view = $viewRenderer->view;
     }     
     
     
     private function hasMailAccess(){
     	if (APPLICATION_ENV == 'production'){
     		return TRUE;
     	}
     	return false;
     }
     
     
     public function send($templateName,$data = null){ 
     	if (!$this->hasMailAccess()){
     		return FALSE; 
     	}
     	
     	$templateMethod = 'template_'.$templateName;
     	if (!method_exists($this,$templateMethod)){
     		throw new Exception('Mail template not found');
     	}
     	 
     	return $this->$templateMethod($data);
   
     }
     
     
     // ----------------------------------
     // TEMPLATES
     // ----------------------------------
     

     protected function template_LostPassword($data){
     	 
     	if (empty($data) || empty($data['email'])){
     		return FALSE;
     	}
     	try{
     		$mail = new Zend_Mail('UTF-8');
     		//@todo, check lang of dealer
     		$mail->setFrom('kris.planckaert@winsol.eu', 'Winsol');
     		$mail->setSubject('webshop: lost password reset');
     		$mail->setBodyText('Hello,<br /><br />Please click link below to proceed with a new password<br /><br />');
     		 
     		$this->view->data = $data;
     		$this->view->userRow = $data;
     		$html = $this->view->render('/mail/lostPassword.phtml');
     		$mail->setBodyHtml($html);
     		$mail->addTo($data['email']); //, $data['Naam']);
     		 
     		$mail->send();
     		return TRUE;
     	}
     	catch(Exception $e){
     		throw $e->getMessage();
     	}
     }     
     

} 

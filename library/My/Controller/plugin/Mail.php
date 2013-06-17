<?php
/**
* Setup view variables
*/
class My_Controller_Plugin_Mail extends Zend_Controller_Plugin_Abstract
{
    // -----------------------------------------------
    // Set all available mail templates as constants
    // -----------------------------------------------
    	const TEMPLATE_ORDER_PRODUCT_REJECT  = 'OrderProductRejected';
    	const TEMPLATE_LOST_PASSWORD  = 'lostPassword';
        const TEMPLATE_ORDER_PRODUCT_ZONDER_ORDERNUMMER  = 'orderProductZonderOrderNr';
    
     public $view;
    
//      public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
//      {
//          $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
//          $viewRenderer->init();
//          $this->view = $viewRenderer->view;
//      }

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
     	
     	//$constants = $this->getConstants();
     	$templateMethod = 'template_'.$templateName;
     	//echo 'pre: ' . $templateMethod; exit;
     	if (!method_exists($this,$templateMethod)){
     		throw new Exception('Mail template not found');
     	}
     	 
     	return $this->$templateMethod($data);
     	// mail('allan.groom@techtronix.be','testing','het werkt');
     	// echo 'mail model é: ';
     	//Zend_Debug::dump($orderProduct);     
     }
     
     
     // ----------------------------------
     // TEMPLATES
     // ----------------------------------
     

     protected function template_OrderProductRejected($data){
         
     	$orderProductModel = new Share_Models_Orderproduct();
     	$orderProduct      = $orderProductModel->getOne($data['orderProductId']);
     
     	$orderModel = new Share_Models_Order();
     	$dealer     = $orderModel->getDealerFromOrder($orderProduct['ID_Order']);
     	if (empty($dealer) || empty($dealer['Emailadres'])){
     		return FALSE;
     	}

     	try{
     		$mail = new Zend_Mail('UTF-8');
     		//@todo, check lang of dealer
     		$mail->setFrom('order@winsol.eu', 'Winsol');
     		
     		$mail->setBodyText('Winsol: fout bestelling.  Gelieve in te loggen in de applicatie');
     		//$mail->send(); return;     
     		//$userRow = $userModel->getOne($orderRow['ID_CreationDealerGebruiker']);
     		$this->view->dealer = $dealer;
     		$this->view->order  = $orderModel->getOne($orderProduct['ID_Order']);
     		$html = $this->view->render('/mail/orderProductRejected.phtml');
                $result=explode(":::",$html);
                $mail->setSubject($result[1]);
     		$mail->setBodyHtml($result[0]);
                if ($dealer['WinsolIntern']) {
                   $dealergebruiker = $this->view->DealergebruikerHelper('getDealergebruikerFromOrder', array($orderProduct['ID_Order']));
                   $mail->addTo($dealergebruiker['username'], $dealergebruiker['firstName']);
                }
                else {
                    $mail->addTo($dealer['Emailadres'], $dealer['Naam']);
                }
     
     		$mail->send();
     		return TRUE;
     	}
     	catch(Exception $e){
     	    return FALSE;
     		//throw $e->getMessage();
     	}     
     }    
     
     
     protected function template_LostPassword($data){
     	 
     	//$orderProductModel = new Share_Models_Orderproduct();
     	//$orderProduct      = $orderProductModel->getOne($data['orderProductId']);
     	 
     	//$orderModel = new Share_Models_Order();
     	//$dealer     = $orderModel->getDealerFromOrder($orderProduct['ID_Order']);
     	if (empty($data) || empty($data['email'])){
     		return FALSE;
     	}
     	try{
     		$mail = new Zend_Mail('UTF-8');
     		//@todo, check lang of dealer
     		$mail->setFrom('WinCal@winsol.eu', 'Winsol');
     		$mail->setSubject('WinCal: lost password reset');
     		$mail->setBodyText('Hello,<br /><br />Please click link below to proceed with a new password<br /><br />');
     		//$mail->send(); return;
     		 
     		//$userRow = $userModel->getOne($orderRow['ID_CreationDealerGebruiker']);
     		$this->view->data = $data;
     		$this->view->userRow = $data;
     		//$this->view->order  = $orderModel->getOne($orderProduct['ID_Order']);
     		$html = $this->view->render('/mail/lostPassword.phtml');
     		$mail->setBodyHtml($html);
     		$mail->addTo($data['email']); //, $data['Naam']);
     		//$mail->addTo('allan.groom@techtronix.be', 'Allan Groom - test');
     		 
     		$mail->send();
     		return TRUE;
     	}
     	catch(Exception $e){
     		throw $e->getMessage();
     	}
     }     
     
    protected function template_orderProductZonderOrderNr($data)
    {
        try{
            $mail = new Zend_Mail('UTF-8');
            //@todo, check lang of dealer
            $mail->setFrom('wincal@winsol.eu', 'Winsol');
            $mail->setSubject('Orders Zonder AS400 Ordernummer');
            $mail->setBodyText('Er zijn "'.$data['aantal'].'" orderproducten zonder AS400 Ordernummer!');
            //$mail->setBodyHtml($html);
            $toAddress = 'kris.planckaert@winsol.eu';            
            $toName = 'Kris Planckaert';
            $mail->addTo($toAddress, $toName);
            if($data['aantal']<>0) {
                $toAddress = 'wincal@winsol.eu';
                $toName = 'WinCAL';
                $mail->addTo($toAddress, $toName);
            }
            $mail->send();
        }
        catch(Exception $e){
            throw $e->getMessage();
        }
    }
} 

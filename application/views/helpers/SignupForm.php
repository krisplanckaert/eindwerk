<?php
class Zend_View_Helper_SignupForm extends Zend_View_Helper_Abstract
{
    public function signupForm(Application_Form_Signup $form)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity()) {
            $username = $auth->getIdentity();
            $logoutUrl = $this->view->url(array('module' => 'default', 'controller' => 'index', 'action' => 'logout'));
            echo $view->translate('lbl_welcome') . ' ' . $username.' <a href='.$logoutUrl.'>'.$this->view->translate('lbl_logout').'</a>';
            return;
        }
        
        
        $html = '<p>'.$this->view->translate('lbl_loginhere').'</p>';
        if($form->processed) {

            $html .= '<p>'.$view->translate('lbl_loginthanks') . '</p>';

        } else {

            $html .= $form->render();
            $html .= '<span><a href="'.$this->view->url(array('controller' => 'index', 'action' => 'register'),NULL,TRUE).'">'. $this->view->translate('lbl_register').'</a></span>';
            $html .= '<br><span><a href="'.$this->view->url(array('controller' => 'index', 'action' => 'lostpassword'),NULL,TRUE).'">'. $this->view->translate('lbl_lostpassword').'</a></span>';
            
        }


        return $html;

    }

}
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
            $logoutUrl = $this->view->url(array('module' => 'default', 'controller' => 'user', 'action' => 'logout'));
            echo $view->translate('lbl_Welkom') . ' ' . $username.' <a href='.$logoutUrl.'>logout</a>';
            return;
        }
        
        
        $html = '<p>'.$this->view->translate('lbl_Hier kan je inloggen').'</p>';
        //$html = '<p>lbl_Hier kan je inloggen</p>';
        if($form->processed) {

            $html .= '<p>'.$view->translate('lbl_Bedankt om in te loggen') . '</p>';

        } else {

            $html .= $form->render();
        }


        return $html;

    }

}
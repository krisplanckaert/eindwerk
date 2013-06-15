<?php

class Zend_View_Helper_Auth extends Zend_View_Helper_Abstract
{
    public function auth()
    {
        $auth = Zend_Auth::getInstance();
        $username = $auth->getIdentity();
        $logoutUrl = $this->view->url(array('controller' => 'user', 'action' => 'logout', 'module' => 'default'));
        $html =  'Welkom '.$username.' <a href='.$logoutUrl.'>logout</a>';
        return $html;
    }
}

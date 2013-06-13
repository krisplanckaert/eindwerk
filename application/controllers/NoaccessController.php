<?php

class NoaccessController extends Zend_Controller_Action
{

    public function indexAction()
    {
        //die('noacces index');
        $this->_helper->layout->disableLayout();
    }


}


<?php

class Dealer_PhotoController extends My_Controller_Action
{

    public function changeAction()
    {
        $photoId = (int) $this->_getParam('photoId'); //$_GET['id];
                
        $photoModel = new Application_Model_Photo();
        $photo = $photoModel->find($photoId)->current()->toArray(); 

        $form = new Dealer_Form_Photo();
        
        $photo = $photoModel->getLocales($photo);
        //Zend_Debug::dump($photo);exit;
        $form->populate($photo);
        
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $photoModel->save($postParams, $photoId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'list')));
            }  
            
        }
        
    }

    public function addAction()
    {
        $form  = new Dealer_Form_Photo;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $photoModel = new Application_Model_Photo();
                $photoModel->save($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'list')));
            }            
        }
    }

    public function verwijderenAction()
    {
        $id = (int) $this->_getParam('id'); 
        $photoModel = new Application_Model_Photo();
        $photoModel->verwijder($id);
        $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'index')));
    }


}








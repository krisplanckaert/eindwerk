<?php

class Dealer_PageController extends My_Controller_Action
{

    public function changeAction()
    {
        $pageId = (int) $this->_getParam('pageId'); //$_GET['id];
                
        $pageModel = new Application_Model_Page();
        $page = $pageModel->find($pageId)->current(); 
               
        $form = new Dealer_Form_Page($pageId);
        $page = $page->toArray();
        $page = $pageModel->getLocales($page);
        
        $form->populate($page);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['toevoegen']);
                $pageModel->save($postParams, $pageId);
                
                $this->_redirect($this->view->url(array('controller'=> 'Page', 'action'=> 'list')));
            }  
        }
    }

    public function addAction()
    {
        $form  = new Dealer_Form_Page;
        $this->view->form = $form;    
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($postParams)) {                                            
                
                unset($postParams['toevoegen']);
                $pageModel = new Application_Model_Page();
                $pageModel->save($postParams);
                
                $this->_redirect($this->view->url(array('controller'=> 'Page', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $pageId = (int) $this->_getParam('pageId'); 
        $pageModel = new Application_Model_Page();
        $pageModel->delete('pageId='.$pageId);
        $this->_redirect($this->view->url(array('controller'=> 'Page', 'action'=> 'list')));
    }


}








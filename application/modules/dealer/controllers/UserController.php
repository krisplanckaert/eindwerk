<?php

class Dealer_UserController extends My_Controller_Action
{
    public function listAction() {
        if($this->authUserRow['roleId']==3) {
            $where = 'roleId<>4';
        } else {
            $where = null;
        }
        $this->view->rows = $this->model->getAll($where);
    }
    
    public function changeAction()
    {
        $userId = (int) $this->_getParam('userId'); //$_GET['id];
                
        $userModel = new Application_Model_User();
        $user = $userModel->find($userId)->current(); 
               
        $form = new Dealer_Form_User($userId);
        $user = $user->toArray();
        //Zend_Debug::dump($user);exit;
        $form->populate($user);
                
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
         
            if ($this->view->form->isValid($postParams)) {                                                           
                  
                unset($postParams['add']);
                if(!$postParams['password']) { 
                    unset($postParams['password']);
                }
                unset($postParams['repeatPassword']);

                $userModel->save($postParams, $userId);
                
                $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'list')));
            }  
        }
     }

    public function addAction()
    {
        $form  = new Dealer_Form_User;
        $this->view->form = $form;    
        if ($this->getRequest()->isPost()){
            $postParams= $this->getRequest()->getPost();
            if ($this->view->form->isValid($postParams)) {                                            
                unset($postParams['toevoegen']);
                $userData = $postParams;
                $userModel = new Application_Model_User();
                $userModel->save($userData);
                
                $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'list')));
            }            
        }
    }

    public function deleteAction()
    {
        $userId = (int) $this->_getParam('userId'); 
        $userModel = new Application_Model_User();
        $userModel->delete('userId='.$userId);
        $this->_redirect($this->view->url(array('controller'=> 'User', 'action'=> 'list')));
    }

}








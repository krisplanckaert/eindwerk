<?php

class Dealer_PhotoController extends My_Controller_Action
{

    public function changeAction()
    {
        $photoId = (int) $this->_getParam('photoId'); //$_GET['id];
                
        $photoModel = new Application_Model_Photo();
        $photo = $photoModel->find($photoId)->current()->toArray(); 
        $photo = $photoModel->getLocale($photo);
        $form = new Dealer_Form_Photo();
        
        $photo = $photoModel->getLocales($photo);

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

    public function deleteAction()
    {
        $photoId = (int) $this->_getParam('photoId'); 
        $photoModel = new Application_Model_Photo();
        $photoModel->delete('photoId='.$photoId);
        $this->_redirect($this->view->url(array('controller'=> 'Photo', 'action'=> 'index')));
    }

    public function ajaxUploadAction() {
        $this->_helper->layout->disableLayout();

        $data = $this->getRequest()->getPost();
        if (empty($_FILES) ) {
                echo 'No files to upload'; exit;
        }
        // ini
        $fileElem   = 'Filedata';
        $tempFile   = $_FILES[$fileElem]['tmp_name'];
        $targetPath = $this->model->getPathUpload();
        $prefix     = date('d.m.Y.H.i.s').'_';

        $fileNameOrig = $_FILES[$fileElem]['name']; //preg_replace("/(\s|%20)/","_",$_FILES['Filedata']['name']); # replace all white spaces and %20 with _
        $fileName    = $fileNameOrig;
        $fileName    = str_replace(" ","_", $fileName);
        $fileName    = str_replace("(","_", $fileName);
        $fileName    = str_replace(")","_", $fileName);
        $targetFile  = str_replace('//','/',$targetPath) . trim($fileName);
        $response = 0;
        if (move_uploaded_file($tempFile,$targetFile)){             
            $fileData = $v= array(
                            'label'     => trim($fileName),
                            'fileNameOrig' => $fileNameOrig,
                            'fileSize'      => filesize($targetFile),
            );
            $photoId = $this->model->insert($fileData);
            if (!empty($photoId)){
                $response=1;
            }
        }
        $this->view->response=$response;
   }
}








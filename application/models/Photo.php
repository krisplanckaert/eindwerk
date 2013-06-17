<?php
class Application_Model_Photo extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'photo';
    protected $_primary = 'photoId';
    protected $autoCompleteFields=false;

    protected $pathUpload;
    
    public function __construct(){
        $this->pathUpload = APPLICATION_PATH . '/modules/dealer/uploads/photos/';
        //$this->pathUpload = PROJECT_PATH . 'httpdocs/com/uploads/orders/';
        parent::__construct();
    }
    
    public function init() {
        $this->localeFields = array('title'=>'title', 'teaser'=>'teaser');
    }
    
    public function getPhotosList() {
        $return = array();
        $photos = $this->getAll();
        foreach($photos as $photo) {
            $return[$photo['photoId']] = $photo['label'];
        }
        return $return;
    }
    
    
    public function getPathUpload(){
        return $this->pathUpload;
    }    
}
?>

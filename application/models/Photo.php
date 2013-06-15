<?php
class Application_Model_Photo extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'photo';
    protected $_primary = 'photoId';
    protected $autoCompleteFields=false;
    
    public function init() {
        $this->localeFields = array('title'=>'title', 'teaser'=>'teaser');
    }
    
    public function getPhotosList() {
        $return = array();
        $photos = $this->getAll();
        foreach($photos as $photo) {
            $return[$photo['photoId']] = $photo['fileName'];
        }
        return $return;
    }
}
?>

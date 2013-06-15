<?php
class Application_Model_Photo extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'photo';
    protected $_primary = 'photoId';
    
    public function init() {
        $this->localeFields = array('title', 'teaser');
    }
}
?>

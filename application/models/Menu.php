<?php
class Application_Model_Menu extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'menu';
    protected $_primary = 'menuId';
    
    public function init() {
        $this->localeFields = array('description');
    }
    
}
?>

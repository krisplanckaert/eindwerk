<?php
//class Application_Model_Winkelmand extends Zend_Db_Table_Abstract
class Application_Model_Locale extends My_Model
{
    //private $db; 
    
    protected $_name = 'locale';
    protected $_primary = 'localeId';
    
    public function getIdByLocale($locale) {
        $fields = array(
            'locale' => $locale,
        );
        $locale = $this->getOneByFields($fields);
        return $locale['localeId'];
    }
}
?>

<?php

class Application_Model_Locale extends My_Model
{
    protected $_name = 'locale';
    protected $_primary = 'localeId';
    
    public function getIdByLocale($locale) {
        $fields = array(
            'locale' => $locale,
        );
        $locale = $this->getOneByFields($fields);
        return $locale['localeId'];
    }
    
    public function getLocaleId() {
        $lang = Zend_Registry::get('Zend_Locale');
        $locale = $this->getOneByField('locale', $lang);
        return $locale['localeId'];
    }
}
?>

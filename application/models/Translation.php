<?php

class Application_Model_Translation extends My_Model
{
    protected $_name = 'translate';
    protected $_primary = 'translateId';
    
    
    public function getTranslationByLocale(Zend_Locale $locale)
    {
        $select = $this->select()->where('locale = ?',$locale);
        $result = $this->fetchAll($select);
        return $result;
    }    
    
    /**
     * 
     * @param Zend_Locale $locale
     * @return Zend_Db_Table_Abstract $result
     */
    public function getTranslationByLang($lang)
    {
        $localeModel = new Application_Model_Locale();
        $fields = array(
            'locale' => $lang,
        );
        $locale = $localeModel->getOneByFields($fields);
        $select = $this->select()->where('localeId = ?',$locale['localeId']);
        $result = $this->fetchAll($select);
        return $result;
    }

}


<?php

class Syntra_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract 
{
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
    {
        $lang = $request->getParam('lang');
        $session = new Zend_Session_Namespace('translation');            
        if(empty($lang)) {
            if (isset($session->translate) && !empty($session->translate)) {
                $lang = $session->translate['locale'];
                $locale = new Zend_Locale($lang);
            } else {
                $lang = 'nl_BE';
                $locale = new Zend_Locale($lang);                
            }
            Zend_Registry::set('Zend_Locale', $locale);
        } else {
            $locale = new Zend_Locale($lang);
            //maak beschikbaar voor alle zend componenten en overal beschikbaar
            Zend_Registry::set('Zend_Locale', $locale);
        }
            
        $translate = new Zend_Translate('array', array('yes' => 'ja'), $locale);
        $cache = false;
        if($cache == true) {
            
        } else {

            $model = new Application_Model_Translation();
            //ophalen alle vertalingen voor huidige locale
            //$translations = $model->getTranslationByLocale($locale);
            $translations = $model->getTranslationByLang($lang);
            //Alle vertalingen toevoegen aan het translate object
            foreach($translations as $translation) 
            {
                $t = array($translation->tag => $translation->translation);
                $translate->addTranslation($t, $locale);
            }
            //Maak overal beschikbaar
            Zend_Registry::set('Zend_Translate', $translate);
        }       
        $session->translate['locale'] = $locale;

    }
}

?>

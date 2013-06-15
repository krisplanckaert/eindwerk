<?php

class My_Form extends Zend_Form {
    public function populate($values) {
        $thisClass = get_class($this);
        //Zend_Debug::dump($thisClass);
        $thisClassModel = new $thisClass;
        $modelName = 'Application_Model_'.substr(strstr(substr(strstr(get_class($this), '_', false),1), '_', FALSE),1);
        //Zend_Debug::dump($modelName);
        $modelObject = new $modelName;
        if($modelObject->getLocaleFields()) {
            $allElements = $this->getElements();
            $localeModel = new Application_Model_Locale();
            $locales = $localeModel->getAll();
            foreach($modelObject->getLocaleFields() as $localeFields) {
                foreach($locales as $locale) {
                    //Zend_Debug::dump($locale);
                    //Zend_Debug::dump($allElements);exit;
                    $allElements[$locale['localeId']]->setValue($values[$localeFields][1]);
                }
            }
        }
        parent::populate($values);
    }
}

?>

<?php

class My_Form extends Zend_Form {
    
    public function populate($values) {
        $thisClass = get_class($this);
        $thisClassModel = new $thisClass;
        $modelName = 'Application_Model_'.substr(strstr(substr(strstr(get_class($this), '_', false),1), '_', FALSE),1);
        $modelObject = new $modelName;
        if($modelObject->getLocaleFields()) {
            $allElements = $this->getElements();
            $localeModel = new Application_Model_Locale();
            $locales = $localeModel->getAll();
            foreach($modelObject->getLocaleFields() as $k => $localeFields) {
                $prefix = preg_match("/\\d/", $k) > 0 ? '' : $k;
                foreach($locales as $locale) {
                    $allElements[$prefix.$locale['localeId']]->setValue($values[$localeFields][$locale['localeId']]);
                }
            }
        }
        parent::populate($values);
    }
}

?>

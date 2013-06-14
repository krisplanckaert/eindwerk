<?php

/**
 * Translate helper
 * Override default view translate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Translate extends Zend_View_Helper_Abstract
{
    public $tr;
    public $view;
	
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }

    protected function TranslateArray($data, $convert = 2, $autoBreak = TRUE){
    	if (empty($data)){
            return NULL;
    	}
    	
    	$translatedData = array();
    	foreach($data as $k=>$v){
            $translatedData[$k] = $this->Translate($v,$convert,$autoBreak);
    	}
    	return $translatedData;    	    	    
    }
	
    /**
    * Translate
    * @param mixed string/array $tag
    * @param int $convert , 1 = htmlentities, 2 = htmlspecialchars, 3 = raw
    * @param bool $autoBreak, convert nl to html-tag <br />
    */
    public function Translate($tag, $convert = 2, $autoBreak = TRUE) {
        
        $this->tr = Zend_Registry::get('Zend_Translate');
        //if(empty($this->tr))return null;
        if (is_array($tag)){
            return $this->translateArray($tag,$convert,$autoBreak);
        }

        $translatedValue = $this->tr->translate($tag);
        if (empty($translatedValue)){
            return NULL;
        }
        
        //echo '<br />** ' . $tag . ' = ' . $translatedValue;exit;
        //return $this->view->escape($translatedValue);

        if (in_array($convert,array(1,2))){
            if ($convert == 1){
                $this->view->setEscape('htmlentities');
            }
            else if ($convert == 2){
                $this->view->setEscape('htmlspecialchars');
            }
            $translatedValue = $this->view->escape($translatedValue);
        }
        //return $translatedValue;

        //echo ' ----------> ' . $translatedValue;
        //echo '** tag = ' . $tag;
         return $autoBreak ? nl2br($translatedValue) : $translatedValue;
    }
 	
}


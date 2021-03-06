<?php
//class Application_Model_Winkelmand extends Zend_Db_Table_Abstract
class Application_Model_Category extends My_Model
{
    protected $_name = 'category';
    protected $_primary = 'categoryId';
    
    public function init() 
    {
        $this->localeFields = array('description');
    }
    
    public function getAllCategories() 
    {
        $select = $this->select()
                ->where('status=1');
        $result = $this->fetchAll($select)->toArray();
        $result = $this->getLocale($result);
        //Zend_Debug::dump($result);exit;
        return $result;
    }
}
?>

<?php
//class Application_Model_Winkelmand extends Zend_Db_Table_Abstract
class Application_Model_Category extends My_Model
{
    protected $_name = 'category';
    protected $_primary = 'categorieId';
    
    public function init()
    {
    	$this->db = $this->getAdapter();
    }    

    public function getAllCategories() {
        $select = $this->select()
                ->where('status=1');
        $result = $this->fetchAll($select);
        return $result;
    }
}
?>

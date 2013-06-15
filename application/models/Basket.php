<?php
//class Application_Model_Winkelmand extends Zend_Db_Table_Abstract
class Application_Model_Basket extends My_Model
{
    protected $_name = 'basket';
    protected $_primary = 'basketId';
    
    public function init() {
        $this->autoCompleteFields = false;   
        parent::init();
    }
    
    public function getBasket() {
        $userModel = new Application_Model_User();
        $userId = $userModel->getUserId();
        $localeModel = new Application_Model_Locale();
        $localeId = $localeModel->getLocaleId();
        $select = $this->db->select();
        $select->from(array('b' => $this->getTableName()));
        $select->join(array('p' => 'product'), 'p.productId = b.productId');
        $select->joinleft(array('pl' => 'productlocale'), 'pl.productId = p.productId and pl.localeId='.$localeId);
        $where = $userId ? 'b.userId = '.$userId : "session='" . session_id()."' and b.userId is null";
        $select->where($where);
        //echo $select; exit;
        return $this->db->fetchAll($select);
    }
    
    public function linkUser() {
        $userModel = new Application_Model_User();
        $userId = $userModel->getUserId();
        $where = "session='".session_id()."' and userId is null";
        $baskets = $this->getAll($where);
        foreach($baskets as $basket) {
            $data = array(
                'userId' => $userId,
            );
            $this->updateById($data, $basket['basketId']);
        }
    }
}
?>

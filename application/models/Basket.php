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
            $fields = array(
                'userId' => $userId,
                'productId' => $basket['productId'],
            );
            $basketCheck = $this->getOneByFields($fields); 
            if($basketCheck) {
                $this->delete('basketId='.$basket['basketId']);
                $data = array(
                    'quantity' => $basket['quantity'] + $basketCheck['quantity'],
                );
                $this->updateById($data, $basketCheck['basketId']);
            } else {
                $data = array(
                    'userId' => $userId,
                );
                $this->updateById($data, $basket['basketId']);
            }
        }
    }
    
    public function addToBasket($data) {
        $userModel = new Application_Model_User();
        $quantity = isset($data['quantity']) ? $data['quantity'] : 1;
        $userId = $userModel->getUserId();
        if($userId) {
            //check winkelmand met userId
            $fields = array(
                'session' => session_id(),
                'userId' => $userId,
                'productId' => $data['productId'],
            );
            $basket = $this->getOneByFields($fields);
        } else {
            //check winkelmand met sessionId
            $fields = array(
                'session' => session_id(),
                'userId' => null,
                'productId' => $data['productId'],
            );
            $basket = $this->getOneByFields($fields);
        }
        if($basket) {
            $quantity = $basket['quantity'] + $quantity;
            $params = array(
                'quantity' => $quantity,
            );
            $this->updateById($params, $basket['basketId']);
        } else {
            $params = array(
                'productId' => $data['productId'],
                'userId' => $userId,
                'session' => session_id(),
                'quantity' => $quantity,
            );
            $this->insert($params);
        }
        $this->view->basket=$this->getBasket();
    }
    
}
?>

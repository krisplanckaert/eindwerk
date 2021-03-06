<?php
class Application_Model_User extends My_Model
{
    protected $_name = 'user';
    protected $_primary = 'userId';
    
    protected $autoCompleteFields=false;
    
    public function init() {
        $this->db = $this->getAdapter();

    }
    
    public function getUserByIdentity($identity) 
    {
        $select = $this->select()->where('name = ?', $identity);
        $result = $this->fetchAll($select)->current();

        return $result;
    }
    
    public function getUserId() {
        $userModel = new Application_Model_User();
        $userId = null;
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $username = $auth->getIdentity();
            $user = $userModel->getOneByField('name', $username);
            $userId = $user ? $user['userId'] : null;
        } 
        return $userId;
    }
   
    public function saveIdentifier($id){
        $eId = uniqid($id . '.', true);
        $dbFields = array(
            'eId' => $eId,
        );
        $this->updateById($dbFields,$id);
        return $eId;
    }
    
}
?>

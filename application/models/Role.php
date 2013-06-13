<?php
class Application_Model_Role extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'role';
    protected $_primary = 'roleId';
    
    public function toevoegen($params) 
    {
        $this->insert($params);        
        
    }
    
    public function wijzigen($params, $id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary.'= ?', $id);
         $this->update($params, $where);   
    }       
        
    public function verwijder($id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary.'= ?', $id);
         $this->delete($where);   
    }    
        
    public function getOne($id,$colName = 'ID')
    {
        if($colName=='ID') {
            $colName = $this->_primary;
        }
    	$where  = '';
    	$where .= $colName . ' = ' .(int)$id;
        $row = parent::fetchRow($where);            
        if (!$row) {
            return FALSE; 
        }
        $this->data = $row->toArray();
        return $this->data;
    }
    
    public function getRolesList() {
        $return = array();
        $roles = $this->getAll()->toArray();
        foreach($roles as $role) {
            $return[$role['roleId']] = $role['role'];
        }
        //Zend_Debug::dump($return);
        return $return;
    }
    
}
?>

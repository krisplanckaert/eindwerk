<?php
class Application_Model_User extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'user';
    protected $_primary = 'userId';
    
    public function getUserByIdentity($identity) 
    {
        $select = $this->select()->where('name = ?', $identity);
        $result = $this->fetchAll($select)->current();
        
        return $result;
    }
    
    public function toevoegen($params) 
    {
        $this->insert($params);        
        
    }
    
    public function wijzigen($params, $id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary.' = ?', $id);
         $this->update($params, $where);   
    }       
        
    public function verwijder($id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary.' = ?', $id);
         $this->delete($where);   
    }    
        
    public function getOne($id,$colName = 'ID')
    {
        if($colName == 'ID') {
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
    
    
}
?>

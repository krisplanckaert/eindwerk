<?php
class Application_Model_Role extends My_Model
{
    protected $_name = 'role';
    protected $_primary = 'roleId';
    
    public function getRolesList() {
        $return = array();
        $roles = $this->getAll();
        foreach($roles as $role) {
            $return[$role['roleId']] = $role['role'];
        }
        return $return;
    }
   
}
?>

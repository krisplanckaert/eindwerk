<?php

class Application_Model_Menurole extends My_Model
{

    protected $_name = 'menurole';
    protected $_primary = 'menuroleId';

    public function getMenuByRole($roleId, $locale) {
        $localeModel = new Application_Model_Locale();
        $localeId = $localeModel->getIdByLocale($locale);
        $select = $this->db->select();
        $select->from(array('mr' => $this->getTableName()));
        $select->join(array('m' => 'menu'), 'm.menuId = mr.menuId', array('label' => 'm.label', 'action' => 'm.action', 'controller' => 'm.controller', 'module' => 'm.module', 'slug' => 'm.slug'));
        $select->join(array('ml' => 'menulocale'), 'ml.menuId = m.menuId');        
        $select->where('mr.roleId = ?', (int)$roleId );
        $select->where('ml.localeId = ?', $localeId );
        //echo $select;exit;
        return $this->db->fetchAll($select);
    }
}


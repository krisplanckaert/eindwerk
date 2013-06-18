<?php

abstract class My_Model extends Zend_Db_Table_Abstract 
{

    protected $errors = array();
    
    public $db;
	
    protected $datagrid;
    protected $enableDatagrid = FALSE;
    
    protected $data;
    
    protected $appName;
    
    protected $authUser;
    
    protected $autoCompleteFields = TRUE;
    
    protected $acl;
    
     /**
     * @var int
     */
    protected $authUserRow;    
    
    /**
     * Selected language, nl/fr
     * @var array
     */
    protected $selectedLang;    
    
    protected $localeFields;
    /**
     * 
     * Retrieve active rows => ID_Status = 1
     * @var bool
     */
    
 // -----------------------------------------
    public function init()
    {
    	$this->db = $this->getAdapter();

        /*$this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
        $userModel = new Application_Model_User();
        $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();*/
        
        $session = new Zend_Session_Namespace('translation');
   	    if (isset($session->translate) && !empty($session->translate)){
         	$this->selectedLang = $session->translate;       	
        }   
    }
    
    public function __construct($config = array(), $enableDataGrid = false)
    {
        if ($enableDataGrid){
            //Zend_Debug::dump($this->dataGrid);
            $dataGrid       = new My_DataGrid(); //Zend_Debug::dump($this->dataGrid);
            $this->dataGrid = $dataGrid->getGrid();
        }                 
        parent::__construct($config);      
    }    
    
    public function query($sql) {
        if (!empty($sql)){
            $db = $this->db;
            $stmt = $db->query($sql);
            $result = $stmt->fetchall();
            return $result;
        }
        else {
            return "";
        }
    }
    
    public function setDataGrid() {         
        if(empty($this->dataGrid) || !$this->dataGrid) {
            $dataGrid       = new My_DataGrid();
            $this->dataGrid = $dataGrid->getGrid();
        }
    }       
    
    public function getAuthUser(){
    	return $this->authUser;    	
    }
    
    public function getAppName(){
    	return $this->appName;
    } 
// --------------------------
// ACL
// --------------------------
    public function setAcl(My_Acl $acl)
    {
    	$this->acl = $acl;
    }
    
    public function getAcl()
    {
    	if (null === $this->acl) {
    		$this->setAcl(new My_Acl($this->authUser));
    	}
    	return $this->acl;
    }

 // -------------------------
 // CRUD
    public function getOne($id,$colName = null)
    {
    	$where  = '';
        if(!$colName) {
            if(is_array($this->_primary)) {
                $colName = $this->_primary[1];
            } else {
                $colName = $this->_primary;
            }
        }
    	$where .= $colName . ' = ' .(int)$id;
        $row = parent::fetchRow($where);            
        if (!$row) {
            return FALSE; 
        }
        $this->data = $row->toArray();
        return $this->data;
    }
    
    public function getOneByField($fieldName,$fieldValue){
    	$where  = '';
    	$where .= $fieldName .' = ' .$this->db->quote($fieldValue);  
    	//echo '==> ' . $where;  	exit;
    	$row = parent::fetchRow($where);    
    	      
        if (!$row) {
            return FALSE; 
        }
       // Zend_Debug::dump($row->toArray()); exit;
        return $row->toArray();    	
    }
    
    
    public function getOneByFields(array $fields,$operator = 'AND'){
    	$where = '0=0'; 
    	foreach($fields as $k=>$v){
            if($v===NULL) {
                $where .= ' '. $operator . ' ' . $k . ' is null';
            } else {
                $where .= ' '. $operator . ' ' . $k . '=' . $this->db->quote($v);
            }
   	}
    	$row = parent::fetchRow($where);            
        if (!$row) {
            return FALSE; 
        }
        $return = $row->toArray();   
        return $return;
    }    
    
    public function getAll($where=null,$order=null)
    {
    	$data = $this->fetchAll($where,$order);
        $result = $data->toArray();
        
        if($this->localeFields) {
            $result = $this->getLocale($result);
        }
        
        return $result;
    }    

    public function getData(){
    	return $this->data;
    }
    
    public function setData(array $data){
    	$this->data = $data;
    }
    
    public function buildSelect($options = NULL){
    	$defaultOptions = array(
    		'key'      => $this->_primary,
    		'value'    => 'Omschrijving',
    		'emptyRow' => TRUE,
    		'where'    => NULL,
    		'order'	   => NULL,
    	);
        $options = !empty($options) && is_array($options) ? array_merge($defaultOptions,(array)$options) : $defaultOptions;
    	$data = $this->getAll($options['where'],$options['order']);
    	if (empty($data)){
    		return array();
    	}
    	$returnData = array();
    	if ($options['emptyRow']){
    		$returnData[''] = '';
    	}
    	foreach($data as $row){
            $returnData[$row[$options['key']]] = $row[$options['value']];
    	}    
    	return $returnData;
    }   
    
  	
 // -------------------------   
    public function getTable()
    {    
    	return $this->getTableName();
    }
    
    public function getTableName()
    {    
    	return $this->_name;
    }    


    /**
     * Insert
     * @return int last insert ID
     */
    public function insert($data) {
    	if ($this->autoCompleteFields){
            $currentTime = date("Y-m-d H:i:s");
            $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();            
            $data['creationUserId'] = $this->authUserRow['userId'];
            $data['creationDate'] = $currentTime;
    	}
        $id = parent::insert($data);
        return $id;
    }

    
    public function updateById(array $data,$id,$primaryKey = '')
    {    	
       $primaryKey = !empty($primaryKey) ? $primaryKey : $this->_primary[1];
       if (empty($id)){
            return FALSE;
       }
       if ($this->autoCompleteFields){
            $currentTime = date("Y-m-d H:i:s");
            $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();
            $data['changeUserId'] = $this->authUserRow['userId'];
            $data['changeDate'] = $currentTime;
       }
       return parent::update($data,$primaryKey . ' = ' . (int)$id); 	
    }
    
    
    /**
     * Update
     * 
     * @param array  $data: fields to update
     * @param mixed int/string $where : 
     * @return int numbers of rows updated
     */
    public function update($data, $where) {
    	if (preg_match('/^([0-9])+$/', $where)) {
            return $this->updateById($data,(int)$where);
    	}
    	if ($this->autoCompleteFields){
            $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
            $userModel = new Application_Model_User();
            $this->authUserRow = $userModel->getUserByIdentity($this->authUser)->toArray();
            $data['changeUserId'] = $this->authUserRow['userId'];
    	}
        return parent::update($data, $where);
    }
    
    public function getLocales($result) {
        $locale = Zend_Registry::get('Zend_Locale');
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale',$locale);        

        $thisClass = get_class($this);
        $childLocaleModelName = $thisClass.'Locale'; 
        $childLocaleModel = new $childLocaleModelName;
        
        $parentKey = lcfirst(substr(strstr(substr(strstr(get_class($this), '_', FALSE),1), '_', FALSE),1)).'Id';

        $where = $parentKey.'='.$result[$parentKey];
        $childLocales = $childLocaleModel->getAll($where);
        
        $localeModel = new Application_Model_Locale();
        $locales = $localeModel->getAll();
        
        foreach($this->localeFields as $k => $localeField) {
            $resultArray=null;
            $keyPrefix = !is_numeric($k) ? $k : '';            
            foreach($childLocales as $childLocale) {
                
                $resultArray[$keyPrefix.$childLocale['localeId']] = $childLocale[$localeField];
            }
            foreach($locales as $localeRow) {
                if(!isset($resultArray[$keyPrefix.$localeRow['localeId']])) {
                    $resultArray[$keyPrefix.$localeRow['localeId']] = '';
                } 
            }
            if($resultArray) $result[$localeField] = $resultArray;
        }
        return $result;
    }
    
   
    public function getLocale($result, $array=false) {
        $locale = Zend_Registry::get('Zend_Locale');
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale',$locale);        
        
        $thisClass = get_class($this);
        $childLocaleModelName = $thisClass.'Locale'; 
        $childLocaleModel = new $childLocaleModelName;
        
        $parentKey = lcfirst(substr(strstr(substr(strstr(get_class($this), '_', FALSE),1), '_', FALSE),1)).'Id';
        if($array) {
            $resultArray = array();
            foreach($result as $k=>$v) {
                $resultArray[$k] = $this->getLocaleExec($v, $parentKey, $childLocaleModel, $localeRow);
            }
            $result = $resultArray;
        } else {
            $result = $this->getLocaleExec($result, $parentKey, $childLocaleModel, $localeRow);
        }
        return $result;
    }

    private function getLocaleExec($result, $parentKey, $childLocaleModel, $localeRow) 
    {
        if(!isset($result[$parentKey])) {
            foreach($result as $k => $v) {
                $where = $parentKey.'='.$v[$parentKey].' and localeId = ' . $localeRow['localeId'];
                $childLocale = $childLocaleModel->getAll($where);
                if($childLocale) {
                    $result[$k]['locale'] = $childLocale[0];
                }
            } 
        } else {
            $where = $parentKey.'='.$result[$parentKey].' and localeId = ' . $localeRow['localeId'];
            $childLocale = $childLocaleModel->getAll($where);
            if($childLocale) {
                $result['locale'] = $childLocale[0];
            }
        }
        return $result;
    }
    
    public function remove($id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary . '= ?', $id);
         $this->delete($where);   
    }    
    
    public function save($data, $id=null) {
        if(isset($data['password'])) $data['password'] = md5($data['password']);
        $modelData = $data;
        if(is_array($this->localeFields)) {
            foreach($this->localeFields as $localeFields) {
                unset($modelData[$localeFields]);
            }
        }
        if (!empty($id)) {
            $this->update($modelData,$id);
        } else {
            if(isset($modelData[$this->_primary])) unset($modelData[$this->_primary]);
            $id = $this->insert($modelData);
            }
        $thisClass = get_class($this);
        if(!strstr($thisClass, 'locale') && $this->localeFields) {
            $childLocaleModelName = $thisClass.'locale'; 
            $childLocaleModel = new $childLocaleModelName;
            foreach($this->localeFields as $localeFields) {
                if(isset($data[$localeFields])) {
                    $localeId = 1;
                    foreach($data[$localeFields] as $k => $v) {
                        $fields = array(
                            $this->_primary[1] => $data[$this->_primary[1]] ? $data[$this->_primary[1]] : $id,
                            'localeId' => $localeId,
                        );
                        $childLocaleRow = $childLocaleModel->getOneByFields($fields);
                        if($childLocaleRow) {
                            $childLocaleData = array(
                                $localeFields => $v,
                            );
                            $childLocaleModel->save($childLocaleData, $childLocaleRow[$childLocaleModel->getPrimary()]);
                        } else {
                            $localeId = filter_var($k, FILTER_SANITIZE_NUMBER_INT);
                            $childLocaleData = array(
                                $this->_primary[1] => $id,
                                $localeFields => $v,
                                'localeId' => $localeId,
                                'translated' => true,
                            );
                            //Zend_Debug::dump($childLocaleData);exit;
                            $childLocaleModel->save($childLocaleData);
                        }
                        $localeId++;
                    }
                }
            }
        } 
        return $id;
    }
    
    public function getPrimary() {
        return $this->_primary[1];
    }
    
    public function getLocaleFields() {
        return $this->localeFields;
    }
}

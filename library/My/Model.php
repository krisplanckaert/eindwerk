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
    
    protected $autoCompleteFields = FALSE;
    
    protected $acl;
    
     /**
     * @var int
     */
    protected $authUserId;    
    
    /**
     * Selected language, nl/fr
     * @var array
     */
    protected $selectedLang;    
    
    
    /**
     * 
     * Retrieve active rows => ID_Status = 1
     * @var bool
     */
    
 // -----------------------------------------
    public function init()
    {
    	$this->db = $this->getAdapter();

        $this->authUser = (array) Zend_Auth::getInstance()->getIdentity();
       
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
    
    public function getWinsolDealerId(){
        return $this->winsolDealerId;
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
            $colName = $this->_primary;
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
        return $data->toArray();
    }    

    public function getData(){
    	return $this->data;
    }
    
    public function setData(array $data){
    	$this->data = $data;
    }
    
    public function buildSelect($options = NULL){
    	$defaultOptions = array(
    		'key'      => $this->_id,
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
    public function insert($data,$autoCompleteFields = true) {
    	if ($autoCompleteFields){
            $currentTime = date("Y-m-d H:i:s");
            $data['creationUserId'] = (int)$this->userId;
            $data['creationDate'] = $currentTime;
    	}
        return parent::insert($data);
    }

    
    public function updateById(array $data,$id,$primaryKey = '')
    {    	
       $primaryKey = !empty($primaryKey) ? $primaryKey : $this->_primary[1];
       if (empty($id)){
            return FALSE;
       }
       if ($this->autoCompleteFields){
            $currentTime = date("Y-m-d H:i:s");
            $data['changeUserId'] = (int) $this->userId;
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
    		$data['changeUserId'] = (int)$this->userId;
    	}
        return parent::update($data, $where);
    }
    
    public function getLocale($result) {
        $locale = Zend_Registry::get('Zend_Locale');
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale',$locale);        
        
        $thisClass = get_class($this);
        $childLocaleModelName = $thisClass.'Locale'; 
        $childLocaleModel = new $childLocaleModelName;
        
        $parent = lcfirst(substr(strstr(substr(strstr(get_class($this), '_', FALSE),1), '_', FALSE),1));

        $parentKey = $parent.'Id';
        foreach($result as $k => $v) {
            $where = $parentKey.'='.$v[$parentKey].' and localeId = ' . $localeRow['localeId'];
            $childLocale = $childLocaleModel->getAll($where);
            $result[$k]['locale'] = $childLocale[0];
        } 
        return $result;
    }

    public function remove($id)
    {
         $where  = $this->getAdapter()->quoteInto($this->_primary . '= ?', $id);
         $this->delete($where);   
    }    

}

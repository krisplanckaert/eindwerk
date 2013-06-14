<?php
class Application_Model_Page extends My_Model
{
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 0;
    
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'page';
    protected $_primary = 'pageId';
    
    public function getAllPages() {
        $select = $this->select()
                ->where('status=1');
        $result = $this->fetchAll($select)->toArray();
        $result = $this->getLocale($result);

        return $result;
    }
    
    public function getPage($locale, $slug = NULL) {
        $localeModel = new Application_Model_Locale();
        $localeRow = $localeModel->getOneByField('locale', $locale); 
        if($slug === null) {
            return;
        }
        $select = $this->select()
                ->from(array('p' => $this->getTableName()))
                ->join(array('pl' => 'pagelocale'), 'pl.pageId=p.pageId',null)
                ->where('p.status = ?', self::STATUS_ONLINE)
                ->where('pl.localeId = ?', $localeRow['localeId'])
                ->where('p.slug = ?', $slug);
        $result = $this->fetchAll($select)->toArray();
        //Zend_Debug::dump($result);exit;
        $result = $this->getLocale($result);
        //Zend_Debug::dump($result[0]);exit;
        return $result[0];
    }
}
?>

<?php
class Application_Model_Photo extends My_Model
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'photo';
    protected $_primary = 'photoId';
    protected $autoCompleteFields=false;

    protected $pathUpload;
    
    public function __construct(){
        $this->pathUpload = 'uploads/photos/';
        parent::__construct();
    }
    
    public function init() {
        $this->localeFields = array('title'=>'title', 'teaser'=>'teaser');
    }
    
    public function getPhotosList() {
        $return = array();
        $photos = $this->getAll();
        foreach($photos as $photo) {
            $return[$photo['photoId']] = $photo['label'];
        }
        return $return;
    }
    
    
    public function getPathUpload(){
        return $this->pathUpload;
    }    

    public function insertLocale($photoId) {
        $localeModel = new Application_Model_Locale();
        $locales = $localeModel->getAll();
        foreach($locales as $locale) {
            $photoLocaleModel = new Application_Model_Photolocale();
            $data = array(
                $this->_primary => $photoId,
                'localeId' => $locale['localeId'],
                'translated' => 0,
            );
            foreach($this->localeFields as $localeField) {
                $data[$localeField] = '';
            }
            $photoLocaleModel->insert($data);
        }
    }
}
?>

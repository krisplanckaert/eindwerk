<?php
class Application_Model_Order extends Zend_Db_Table_Abstract
{
    //definieren hoe de tabel eruit ziet    
    protected $_name = 'order';
    protected $_primary = 'orderId';

}
?>

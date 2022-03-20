<?php
/**
 * @package     Gamuza_PicPay
 * @copyright   Copyright (c) 2020 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

class Gamuza_PicPay_Model_Mysql4_Transaction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct ()
    {
        $this->_init ('picpay/transaction');
    }
}


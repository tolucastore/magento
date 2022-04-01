<?php
/**
 * @package     Gamuza_Basic
 * @copyright   Copyright (c) 2022 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

/**
 * Entity attribute option VALUE collection
 */
class Gamuza_Basic_Model_Mysql4_Eav_Entity_Attribute_Option_Value_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct ()
    {
        $this->_init ('basic/eav_entity_attribute_option_value');
    }
}


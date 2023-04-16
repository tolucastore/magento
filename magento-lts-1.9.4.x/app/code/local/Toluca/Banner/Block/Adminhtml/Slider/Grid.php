<?php
/*
 * @package     Toluca_Banner
 * @copyright   Copyright (c) 2023 Gamuza Technologies (https://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

class Toluca_Banner_Block_Adminhtml_Slider_Grid
    extends Magebees_Responsivebannerslider_Block_Adminhtml_Slider_Grid
{
    protected function _prepareColumns()
    {
        $result = parent::_prepareColumns();

        $this->addColumn(
            'statuss', array(
                'header'    => Mage::helper('banner')->__('Status'),
                'align'     => 'left',
                'width'     => '80px',
                'index'     => 'statuss',
                'type'      => 'options',
                'options'   => array(
                    1 => Mage::helper('banner')->__('Enabled'),
                    0 => Mage::helper('banner')->__('Disabled'),
                ),
            )
        );

        return $result;
    }

    public function getRowUrl($row) 
    {
        // nothing
    }
}


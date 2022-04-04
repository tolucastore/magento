<?php
/**
 * @package     Gamuza_Basic
 * @copyright   Copyright (c) 2022 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

class Gamuza_Basic_Adminhtml_Shipping_TablerateController extends Mage_Adminhtml_Controller_Action
{
	protected function _isAllowed ()
	{
	    return Mage::getSingleton ('admin/session')->isAllowed ('admin/shipping/tablerate');
	}

	protected function _initAction ()
	{
		$this->loadLayout ()
            ->_setActiveMenu ('shipping/tablerate')
            ->_addBreadcrumb(
                Mage::helper ('basic')->__('Table Rates Manager'),
                Mage::helper ('basic')->__('Table Rates Manager')
            )
        ;

		return $this;
	}

	public function indexAction ()
	{
	    $this->_title ($this->__('Shipping'));
	    $this->_title ($this->__('Table Rates Manager'));

		$this->_initAction ();

		$this->renderLayout ();
	}
}


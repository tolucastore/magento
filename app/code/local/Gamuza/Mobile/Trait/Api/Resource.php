<?php
/**
 * @package     Gamuza_Mobile
 * @copyright   Copyright (c) 2017 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA 02110-1301, USA.
 */

/**
 * See the AUTHORS file for a list of people on the Gamuza Team.
 * See the ChangeLog files for a list of changes.
 * These files are distributed with gamuza_mobile-magento at http://github.com/gamuzatech/.
 */

trait Gamuza_Mobile_Trait_Api_Resource
{
    /**
     * Retrieves quote by customer identifier and store code
     *
     * @param int $quoteId
     * @param string|int $store
     * @return Mage_Sales_Model_Quote
     */
    protected function _getCustomerQuote($store, $createNewQuote = false)
    {
        $storeId = Mage_Core_Model_App::DISTRO_STORE_ID;

        $customerDomain = Mage::getStoreConfig (Mage_Customer_Model_Customer::XML_PATH_DEFAULT_EMAIL_DOMAIN);
        $customerEmail  = sprintf ('%s@%s', $store, $customerDomain);

        /** @var $quote Mage_Sales_Model_Quote */
        $quote = Mage::getModel("sales/quote")
            ->setStoreId($storeId)
            ->load($customerEmail, 'customer_email')
        ;

        if ((!$quote || !$quote->getId()) && $createNewQuote)
        {
            $quote = $this->_createNewQuote ($storeId, $customerEmail);
        }

        if (!$quote || !$quote->getId())
        {
            $this->_fault('quote_not_exists');
        }

        $quote->afterLoad();

        return $quote;
    }

    /**
     * Create new quote for shopping cart
     *
     * @param int|string $store
     * @return int
     */
    protected function _createNewQuote ($storeId, $customerEmail)
    {
        $remoteIp = Mage::helper('core/http')->getRemoteAddr(false);

        $firstName = Mage::helper ('customer')->__('First Name');
        $lastName  = Mage::helper ('customer')->__('Last Name');

        try
        {
            /*@var $quote Mage_Sales_Model_Quote*/
            $quote = Mage::getModel('sales/quote')
                ->setStoreId($storeId)
                ->setIsActive(true)
                ->setIsMultiShipping(false)
                ->setRemoteIp($remoteIp)
                ->setCustomerFirstname ($firstName)
                ->setCustomerLastname ($lastName)
                ->setCustomerEmail ($customerEmail)
                ->save()
            ;

            $customerData = array(
                'mode'      => Mage_Checkout_Model_Type_Onepage::METHOD_GUEST,
                'firstname' => $firstName,
                'lastname'  => $lastName,
                'email'     => $customerEmail,
            );

            Mage::getModel ('checkout/cart_customer_api')->set ($quote->getId (), $customerData, $storeId);

            $quote->setCustomerGroupId (0)
                ->setCustomerIsGuest (1)
                ->save()
            ;
        }
        catch (Mage_Core_Exception $e)
        {
            $this->_fault('create_quote_fault', $e->getMessage());
        }

        return $quote;
    }

    protected function _getPaymentMethodAvailableCcTypes ($method)
    {
        $ccTypes = Mage::getSingleton('mobile/payment_config')->getCcTypes();

        $methodCcTypes = explode(',', $method->getConfigData('cctypes'));

        foreach ($ccTypes as $code => $title)
        {
            if (!in_array($code, $methodCcTypes))
            {
                unset($ccTypes[$code]);
            }
        }

        if (empty($ccTypes))
        {
            return null;
        }

        return $ccTypes;
    }

    public function _getCcAvailableInstallments ($quote, $method)
    {
        return null;
    }
}


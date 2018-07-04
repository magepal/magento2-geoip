<?php
/**
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GeoIp\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Is enabled
     *
     * @param null $store_id
     * @return bool
     */
    public function isEnabled($store_id = null)
    {
        return $this->isSetFlag('general/active', $store_id);
    }

    public function getIgnoreUserAgentArray()
    {
        return (array) array_map(
            "trim",
            explode(',', $this->getConfigValue('restriction/ignore_user_agent'))
        );
    }

    public function getIgnoreIpAddressArray()
    {
        return (array) array_map(
            "trim",
            explode(',', $this->getConfigValue('restriction/ignore_ip_address'))
        );
    }

    /**
     * Get system config
     *
     * @param String path
     * @param \Magento\Store\Model\ScopeInterface::SCOPE_STORE $store
     * @return string
     */
    public function getConfigValue($path, $store_id = null)
    {
        $path = 'geo_ip/' . $path;
        //return value from core config
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * Get system config
     *
     * @param String path
     * @param \Magento\Store\Model\ScopeInterface::SCOPE_STORE $store
     * @return string
     */
    public function isSetFlag($path, $store_id = null)
    {
        $path = 'geo_ip/' . $path;
        //return value from core config
        return $this->scopeConfig->isSetFlag(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }
}

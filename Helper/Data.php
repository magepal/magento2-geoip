<?php
/**
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GeoIp\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package MagePal\GeoIp\Helper
 */
class Data extends AbstractHelper
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

    /**
     * @return array
     */
    public function getIgnoreUserAgentArray()
    {
        return (array) array_map(
            "trim",
            explode(',', $this->getConfigValue('restriction/ignore_user_agent'))
        );
    }

    /**
     * @return array
     */
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
     * @param ScopeInterface::SCOPE_STORE $store
     * @return string
     */
    public function getConfigValue($path, $store_id = null)
    {
        $path = 'geo_ip/' . $path;
        //return value from core config
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * Get system config
     *
     * @param String path
     * @param ScopeInterface::SCOPE_STORE $store
     * @return string
     */
    public function isSetFlag($path, $store_id = null)
    {
        $path = 'geo_ip/' . $path;
        //return value from core config
        return $this->scopeConfig->isSetFlag(
            $path,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }
}

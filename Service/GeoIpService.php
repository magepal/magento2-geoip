<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GeoIp\Service;

use GeoIp2\Database\Reader;
use GeoIp2\Database\ReaderFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Module\Dir as ModuleDirectory;

class GeoIpService
{

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ModuleDirectory
     */
    protected $moduleDirectory;

    /**
     * @var ReaderFactory
     */
    protected $readerFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var RemoteAddress
     */
    protected $remoteAddress;

    /**
     * @param ModuleDirectory $moduleDirectory
     * @param ReaderFactory $readerFactory
     * @param RemoteAddress $remoteAddress
     * @param RequestInterface $request
     */
    public function __construct(
        ModuleDirectory $moduleDirectory,
        ReaderFactory $readerFactory,
        RemoteAddress $remoteAddress,
        RequestInterface $request
    ) {
        $this->moduleDirectory = $moduleDirectory;
        $this->readerFactory = $readerFactory;
        $this->request = $request;
    }

    /**
     * @return Reader
     */
    private function getReader()
    {
        if ($this->reader === null) {
            $path = $this->moduleDirectory->getDir('MagePal_GeoIp');
            $filename =  '/var/GeoLite2-Country.mmdb';
            $this->reader = $this->readerFactory->create(['filename' => $path . $filename]);
        }

        return $this->reader;
    }

    /**
     * Lookup country from remote address.
     *
     * @param $ipAddress
     * @return null|string
     */
    public function getCountryByIpAddress($ipAddress)
    {
        try {
            return $this->getReader()->country($ipAddress)->country->isoCode;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Lookup country from remote address.
     *
     * @return null|string
     */
    public function getCountry()
    {
        return $this->getCountryByIpAddress($this->getClientIp());
    }

    /**
     * Get user ip address
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->request->getServer('HTTP_X_FORWARDED_FOR') ?? $this->remoteAddress->getRemoteAddress();
    }
}

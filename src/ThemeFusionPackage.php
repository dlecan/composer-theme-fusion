<?php

declare(strict_types=1);

namespace SzepeViktor\Composer\ThemeFusion;

use Composer\Package\Package;
use Composer\Package\Version\VersionParser;

class ThemeFusionPackage extends Package
{
    public const VENDOR_NAME = 'theme-fusion';

    /**
     * @var string
     */
    protected $fusionName;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var ThemeFusionApi
     */
    protected $api;

    public function __construct(string $name, string $slug, string $version, string $url, ThemeFusionApi $api)
    {
        $this->fusionName = $name;
        $this->distUrl = $url;
        $this->api = $api;

        // Set fake versions to avoid API call
        parent::__construct(self::VENDOR_NAME . '/' . $slug, $version, $version);
    }

    public function isDev(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return 'wordpress-plugin';
    }

    /**
     * {@inheritDoc}
     */
    public function getDistType()
    {
        return 'zip';
    }

    /**
     * {@inheritDoc}
     */
    public function getSourceUrl(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getDistUrl(): string
    {
        if ($this->distUrl !== null && $this->distUrl !== '') {
            return $this->distUrl;
        }

        $this->distUrl = $this->api->getDownloadUrl($this->fusionName);

        return $this->distUrl;
    }

    /**
     * @param string $url
     */
    public function setDistUrl($url): void
    {
        $this->distUrl = $url;
    }

    /**
     * @return bool
     */
    public function isAbandoned()
    {
        return false;
    }
}
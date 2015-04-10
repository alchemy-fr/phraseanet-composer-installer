<?php
namespace Composer\Installers;

use Composer\Composer;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;

class PhraseanetInstaller extends LibraryInstaller
{
    const PHRASEANET_PLUGIN_PREFIX = 'phraseanet/plugin-';
    const PHRASEANET_PLUGIN_PREFIX_LENGTH = 18;

    public function __construct(IOInterface $io, Composer $composer, $type = 'library', Filesystem $filesystem = null)
    {
        parent::__construct($io, $composer, 'phraseanet-plugin', $filesystem);
    }

    protected function getPackageBasePath(PackageInterface $package)
    {
        $prefix = substr($package->getPrettyName(), 0, self::PHRASEANET_PLUGIN_PREFIX_LENGTH);
        if (self::PHRASEANET_PLUGIN_PREFIX !== $prefix) {
            throw new \InvalidArgumentException(
                'Unable to install plugin, phraseanet plugins should always start their package name with '
                .'"phraseanet/plugin-"'
            );
        }

        return 'plugins/' . substr($package->getPrettyName(), self::PHRASEANET_PLUGIN_PREFIX_LENGTH);
    }
}

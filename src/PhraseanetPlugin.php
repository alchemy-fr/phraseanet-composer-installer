<?php
namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class PhraseanetPlugin implements PluginInterface
{
    /** @var callable */
    private $installerFactory;

    /**
     * @param Callable|null $installerFactory Factory used to create an installer
     */
    public function __construct($installerFactory = null)
    {
        if (!is_callable($installerFactory)) {
            $installerFactory = function (Composer $composer, IOInterface $io) {
                return new PhraseanetInstaller($io, $composer);
            };
        }
        $this->installerFactory = $installerFactory;
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        $factory = $this->installerFactory;
        $composer->getInstallationManager()->addInstaller($factory($composer, $io));
    }
}

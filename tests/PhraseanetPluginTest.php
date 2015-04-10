<?php
namespace Composer\Installers\Test;

use Composer\Installers\PhraseanetPlugin;
use Prophecy\Argument;

class PhraseanetPluginTest extends \PHPUnit_Framework_TestCase
{
    public function testItImplementsPluginInterface()
    {
        $this->assertInstanceOf('Composer\\Plugin\\PluginInterface', new PhraseanetPlugin());
    }

    public function testItAddsPhraseanetInstallerToComposerInstallationManager()
    {
        $installer = $this->prophesize('Composer\\Installers\\PhraseanetInstaller');

        $installationManager = $this->prophesize('Composer\\Installer\\InstallationManager');
        $installationManager->addInstaller($installer->reveal())->shouldBeCalled();

        $composer = $this->prophesize('Composer\\Composer');
        $composer->getInstallationManager()->willReturn($installationManager->reveal());

        $io = $this->prophesize('Composer\\IO\\IOInterface');

        $installerFactory = function () use ($installer) {
            return $installer->reveal();
        };

        $plugin = new PhraseanetPlugin($installerFactory);
        $plugin->activate($composer->reveal(), $io->reveal());
    }
}

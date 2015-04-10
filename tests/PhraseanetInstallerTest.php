<?php
namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Config;
use Composer\Installers\PhraseanetInstaller;
use Composer\Package\Package;
use Prophecy\Prophecy\ObjectProphecy;

class PhraseanetInstallerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ObjectProphecy */
    private $io;
    /** @var Composer */
    private $composer;

    protected function setUp()
    {
        $this->io = $this->prophesize('Composer\\IO\\IOInterface');

        $config = new Config();
        $this->composer = new Composer();
        $this->composer->setConfig($config);
        $downloadManager = $this->prophesize('Composer\\Downloader\\DownloadManager');
        $this->composer->setDownloadManager($downloadManager->reveal());
    }

    public function testItSupportsPhraseanetPluginPackageType()
    {
        $installer = new PhraseanetInstaller($this->io->reveal(), $this->composer);

        $this->assertTrue($installer->supports('phraseanet-plugin'));
    }

    public function testItsBasePackagePathIsCorrectlyComputed()
    {
        $installer = new PhraseanetInstaller($this->io->reveal(), $this->composer);

        $package = new Package('phraseanet/plugin-test', '1.0.0', '1.0.0');
        $package->setType('phraseanet-plugin');

        $result = $installer->getInstallPath($package);

        $this->assertEquals('plugins/test', $result);
    }

    public function testItThrowsExceptionOnInvalidPackageNaming()
    {
        $installer = new PhraseanetInstaller($this->io->reveal(), $this->composer);

        $package = new Package('myvendor/plugin-test', '1.0.0', '1.0.0');
        $package->setType('phraseanet-plugin');

        $this->setExpectedException('InvalidArgumentException');

        $installer->getInstallPath($package);
    }
}

<?php
namespace Puppy\Service;

use Puppy\Service\resources\ConfigMock;

/**
 * Class TemplateTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{

    public function test__invokeWithoutConfigForDirectoryMain()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.main" for the path to the template files'
        );
        new Template(new ConfigMock([]));
    }

    public function test__invokeWithoutConfigForDirectoryCache()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.cache" for the path to the template cache'
        );
        new Template(new ConfigMock([
            'template.directory.main' => 'main',
        ]));
    }

    public function test__invoke()
    {
        $template = new Template(new ConfigMock([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
        ]));
        /**
         * @var \Twig_Environment $result
         */
        $result = $template();
        $this->assertInstanceOf('Twig_Environment', $result);
    }

    public function test__invokeWithDefaultDebugMode()
    {
        $template = new Template(new ConfigMock([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
        ]));
        /**
         * @var \Twig_Environment $result
         */
        $result = $template();
        $this->assertFalse($result->isDebug());
    }

    public function test__invokeWithDebugMode()
    {
        $template = new Template(new ConfigMock([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
            'template.debug' => true,
        ]));
        /**
         * @var \Twig_Environment $result
         */
        $result = $template();
        $this->assertTrue($result->isDebug());
    }
}
 
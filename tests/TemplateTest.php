<?php
namespace Puppy\Service;

/**
 * Class TemplateTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{

    public function test__invokeWithoutConfig()
    {
        $template = new Template();
        $this->setExpectedException(
            'InvalidArgumentException',
            'Service "config" not found'
        );
        $template(new \ArrayObject());
    }

    public function test__invokeWithoutConfigForDirectoryMain()
    {
        $template = new Template();
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.main" for the path to the template files'
        );
        $template(new \ArrayObject(['config' => new \ArrayObject([])]));
    }

    public function test__invokeWithoutConfigForDirectoryCache()
    {
        $template = new Template();
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.cache" for the path to the template cache'
        );
        $template(new \ArrayObject(['config' => new \ArrayObject([
            'template.directory.main' => __DIR__,
        ])]));
    }

    public function test__invoke()
    {
        $template = new Template();
        /**
         * @var \Twig_Environment $result
         */
        $result = $template(new \ArrayObject(['config' => new \ArrayObject([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
        ])]));
        $this->assertInstanceOf('Twig_Environment', $result);
    }

    public function test__invokeWithDefaultDebugMode()
    {
        $template = new Template();
        /**
         * @var \Twig_Environment $result
         */
        $result = $template(new \ArrayObject(['config' => new \ArrayObject([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
        ])]));
        $this->assertFalse($result->isDebug());
    }

    public function test__invokeWithDebugMode()
    {
        $template = new Template();
        /**
         * @var \Twig_Environment $result
         */
        $result = $template(new \ArrayObject(['config' => new \ArrayObject([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
            'template.debug' => true,
        ])]));
        $this->assertTrue($result->isDebug());
    }
}
 
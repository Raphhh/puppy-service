<?php
namespace Puppy\Service\Twig;

/**
 * Class TwigExtensionTest
 * @package Puppy\Service\Twig
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TwigExtensionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetName()
    {
        $extension = new TwigExtension(new \ArrayObject());
        $this->assertSame('puppy-twig-extension', $extension->getName());
    }

    public function testGetGlobals()
    {
        $services = new \ArrayObject();
        $extension = new TwigExtension($services);
        $this->assertSame(
            ['services' => $services],
            $extension->getGlobals());
    }

    public function testGetFilters()
    {
        $extension = new TwigExtension(new \ArrayObject([
            'config' => [ 'baseUrl' => '/my/url/']
        ]));
        $filters = $extension->getFilters();
        $this->assertCount(1, $filters);
        $this->assertCount(1, $filters);
        $callback = $filters[0]->getCallable();
        $this->assertSame('/my/url/string/', $callback('/string/'));
    }
}

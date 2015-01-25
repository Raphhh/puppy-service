<?php
namespace Puppy\Service;

use Puppy\Service\resources\ConfigMock;
use Puppy\Service\resources\RequestMock;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateRouterTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateRouterTest extends \PHPUnit_Framework_TestCase
{
    private $cwd;

    public function setUp()
    {
        $this->cwd = getcwd();
        chdir(__DIR__ . '/resources');
    }

    public function tearDown()
    {
        chdir($this->cwd);
    }

    public function test__invokeWithoutConfigForDirectoryMain()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.main" for the path to the template files'
        );
        new TemplateRouter(new ConfigMock([]));
    }

    public function test__invokeWithoutConfigForDirectoryCache()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.cache" for the path to the template cache'
        );
        new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'main',
        ]));
    }

    public function test__invokeWithoutRequestService()
    {
        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => __DIR__,
            'template.directory.cache' => __DIR__,
        ]));
        $this->setExpectedException(
            'InvalidArgumentException',
            'Service "request" not found'
        );
        $template(new \ArrayObject([]));
    }

    public function test__invokeWithEmptyRequest()
    {
        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => new Request()
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithSlashRequest()
    {
        $request = new RequestMock();
        $request->setRequestUri('/');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithExistingFile()
    {
        $request = new RequestMock();
        $request->setRequestUri('index.html');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithExistingFileWithSlash()
    {
        $request = new RequestMock();
        $request->setRequestUri('/index.html');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithoutExistingFile()
    {
        $request = new RequestMock();
        $request->setRequestUri('none');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeForSubDirectory()
    {
        $request = new RequestMock();
        $request->setRequestUri('bar');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeForAssociatedFileDirectory()
    {
        $request = new RequestMock();
        $request->setRequestUri('foo');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'foo.html.twig',
            $result
        );
    }

    public function test__invokeForAssociatedFileDirectoryWithSlashes()
    {
        $request = new RequestMock();
        $request->setRequestUri('/foo/');

        $template = new TemplateRouter(new ConfigMock([
            'template.directory.main' => 'templates',
            'template.directory.cache' => 'templates',
        ]));

        $result = $template(
            new \ArrayObject([
                'request' => $request
            ])
        );
        $this->assertSame(
            'templates' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'foo.html.twig',
            $result
        );
    }
}
 
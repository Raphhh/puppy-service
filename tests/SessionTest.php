<?php
namespace Puppy\Service;

/**
 * Class SessionTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function test__invoke()
    {
        $services = new \ArrayObject();
        $services['config'] = new \ArrayObject([
            'session.sessionStorageClass' => 'Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage'
        ]);

        $session = new Session();
        $result = $session($services);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Session', $result);

        /**
         * @var \Symfony\Component\HttpFoundation\Session\Session $result
         */
        $this->assertTrue($result->isStarted());

    }
}
 
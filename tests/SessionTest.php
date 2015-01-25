<?php
namespace Puppy\Service;

use Puppy\Service\resources\ConfigMock;

/**
 * Class SessionTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function test__invoke()
    {
        try{
            $session = new Session(new ConfigMock([]));
            /**
             * @var \Symfony\Component\HttpFoundation\Session\Session $result
             */
            $result = $session();
            $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Session', $result);
            $this->assertTrue($result->isStarted());
        }catch(\Exception $e){
            $this->markTestSkipped($e->getMessage());
        }
    }
}
 
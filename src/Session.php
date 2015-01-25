<?php
namespace Puppy\Service;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

/**
 * Class Session
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Session
{
    /**
     * @return SymfonySession
     */
    public function __invoke()
    {
        $session = new SymfonySession();
        $session->start();
        return $session;
    }
}
 
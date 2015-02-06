<?php
namespace Puppy\Service;

use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

/**
 * Class Template
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Template
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param \ArrayAccess $services
     * @throws \InvalidArgumentException
     * @return Twig_Environment
     */
    public function __invoke(\ArrayAccess $services)
    {
        if (empty($services['config'])) {
            throw new \InvalidArgumentException('Service "config" not found');
        }
        return $this->buildTwig($services['config'])->addContext($services)->twig;
    }

    /**
     * @param \ArrayAccess $config
     * @throws \InvalidArgumentException
     */
    private function validConfig(\ArrayAccess $config)
    {
        if (empty($config['template.directory.main'])) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.main" for the path to the template files'
            );
        }

        if (empty($config['template.directory.cache'])) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.cache" for the path to the template cache'
            );
        }
    }

    /**
     * @param \ArrayAccess $config
     * @return $this
     */
    private function buildTwig(\ArrayAccess $config)
    {
        $this->validConfig($config);

        $this->twig = new Twig_Environment(
            new Twig_Loader_Filesystem($config['template.directory.main']),
            array(
                'cache' => $config['template.directory.cache'],
                'debug' => !empty($config['template.debug']),
                'strict_variables' => true,
            )
        );

        return $this;
    }

    /**
     * @param \ArrayAccess $services
     * @return $this
     */
    private function addContext(\ArrayAccess $services)
    {
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->twig->addGlobal('services', $services);
        return $this;
    }
}

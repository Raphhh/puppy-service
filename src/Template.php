<?php
namespace Puppy\Service;

use Puppy\Config\IConfig;
use Twig_Environment;
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
        return $this->buildTwig($services['config'])->addGlobals($services)->twig;
    }

    /**
     * @param IConfig $config
     * @throws \InvalidArgumentException
     */
    private function validConfig(IConfig $config)
    {
        if (!$config->get('template.directory.main')) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.main" for the path to the template files'
            );
        }
    }

    /**
     * @param IConfig $config
     * @return $this
     */
    private function buildTwig(IConfig $config)
    {
        $this->validConfig($config);

        $this->twig = new Twig_Environment(
            new Twig_Loader_Filesystem($config->get('template.directory.main')),
            array(
                'cache' => $config->get('template.directory.cache'),
                'debug' => (bool)$config->get('template.debug'),
                'strict_variables' => true,
            )
        );

        return $this;
    }

    /**
     * @param \ArrayAccess $services
     * @return $this
     */
    private function addGlobals(\ArrayAccess $services)
    {
        $this->twig->addGlobal('services', $services);
        return $this;
    }
}

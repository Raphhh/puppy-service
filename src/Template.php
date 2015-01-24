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
class Template extends Service
{
    /**
     * @param IConfig $config
     * @throws \InvalidArgumentException
     */
    public function __construct(IConfig $config)
    {
        if (!$config->get('template.directory.main')) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.main" for the path to the template files'
            );
        }

        if (!$config->get('template.directory.cache')) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.cache" for the path to the template cache'
            );
        }

        parent::__construct($config);
    }

    /**
     * @return Twig_Environment
     */
    public function __invoke()
    {
        return new Twig_Environment(
            new Twig_Loader_Filesystem($this->getConfig()->get('template.directory.main')),
            array(
                'cache' => $this->getConfig()->get('template.directory.cache'),
                'debug' => (bool)$this->getConfig()->get('template.debug'),
                'strict_variables' => true,
            )
        );
    }
}

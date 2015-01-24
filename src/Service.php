<?php
namespace Puppy\Service;

use Puppy\Config\IConfig;

abstract class Service
{
    /**
     * @var IConfig
     */
    private $config;

    /**
     * @param IConfig $config
     * @throws \InvalidArgumentException
     */
    public function __construct(IConfig $config)
    {
        $this->setConfig($config);
    }

    /**
     * Getter of $config
     *
     * @return IConfig
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * Setter of $config
     *
     * @param IConfig $config
     */
    private function setConfig(IConfig $config)
    {
        $this->config = $config;
    }
}
 
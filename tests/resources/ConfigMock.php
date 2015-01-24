<?php
namespace Puppy\Service\resources;

use Puppy\Config\IConfig;

/**
 * Class ConfigMock
 * @package Puppy\Service\resources
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ConfigMock implements IConfig
{

    /**
     * @var array
     */
    private $vars;

    /**
     * @param array $vars
     */
    public function __construct(array $vars){
        $this->vars = $vars;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if(isset($this->vars[$key])){
            return $this->vars[$key];
        }
        return null;
    }
}
 
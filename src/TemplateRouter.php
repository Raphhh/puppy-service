<?php
namespace Puppy\Service;

use Puppy\Config\IConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateRouter
 * returns the templates from route
 *
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateRouter extends Service
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
     * @param \ArrayAccess $services
     * @throws \InvalidArgumentException
     * @return string
     */
    public function __invoke(\ArrayAccess $services)
    {
        if (!isset($services['request'])) {
            throw new \InvalidArgumentException('Service "request" not found');
        }

        $directory = $this->getTemplatesDirectory();
        foreach ($this->getPathList($services['request']) as $path) {
            if (file_exists($directory . $path)) {
                return $directory . $path;
            }
        }

        return '';
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    private function getPathList(Request $request)
    {
        $pathList = [];
        $urlData = parse_url($request->getRequestUri());
        if (!empty($urlData['path']) && $urlData['path'] !== '/') {
            $urlData['path'] = trim($urlData['path'], '/');
            $pathList[] = $urlData['path'] . $this->getExtendedFileExtension();
            $pathList[] = $urlData['path'] . DIRECTORY_SEPARATOR . $this->getDefaultFile();
        }
        $pathList[] = $this->getDefaultFile();
        return $pathList;
    }

    /**
     * @return string
     */
    private function getDefaultFile()
    {
        if ($this->getConfig()->get('template.file.default')) {
            return $this->getConfig()->get('template.file.default') . $this->getTemplateFileExtension();
        }
        return 'index' . $this->getExtendedFileExtension();
    }

    /**
     * @return string
     */
    private function getServerFileExtension()
    {
        if ($this->getConfig()->get('template.file.server.extension')) {
            return $this->getConfig()->get('template.file.server.extension');
        }
        return '.html';
    }

    /**
     * @return string
     */
    private function getTemplateFileExtension()
    {
        if ($this->getConfig()->get('template.file.template.extension')) {
            return $this->getConfig()->get('template.file.template.extension');
        }
        return '.twig';
    }

    /**
     * @return string
     */
    private function getExtendedFileExtension()
    {
        return $this->getServerFileExtension() . $this->getTemplateFileExtension();
    }

    /**
     * @return string
     */
    private function getTemplatesDirectory()
    {
        return $this->getConfig()->get(
            'template.directory.main'
        ) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    }
}
 
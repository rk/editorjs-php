<?php

namespace EditorJS;

/**
 * Class ConfigLoader
 *
 * @package EditorJS
 */
class ConfigLoader
{
    public $tools = [];
    public $cachePath;

    /**
     * ConfigLoader constructor
     *
     * @param string $configuration – configuration data
     *
     * @throws EditorJSException
     */
    public function __construct($configuration)
    {
        if (empty($configuration)) {
            throw new EditorJSException("Configuration data is empty");
        }

        $config = json_decode($configuration, true);
        $this->loadTools($config);
        $this->loadOther($config);
    }

    /**
     * Load settings for tools from configuration
     *
     * @param array $config
     *
     * @throws EditorJSException
     */
    private function loadTools($config)
    {
        if (!isset($config['tools'])) {
            throw new EditorJSException('Tools not found in configuration');
        }

        foreach ($config['tools'] as $toolName => $toolData) {
            if (isset($this->tools[$toolName])) {
                throw new EditorJSException("Duplicate tool $toolName in configuration");
            }

            $this->tools[$toolName] = $this->loadTool($toolData);
        }
    }

    /**
     * Load settings for tool
     *
     * @param array $data
     *
     * @return array
     */
    private function loadTool($data)
    {
        return $data;
    }

    /**
     * Load other configuration settings such as the cache directory.
     *
     * @param array $config
     * @return void
     */
    private function loadOther($config)
    {
        $this->cachePath = !empty($config['cache_path'])
            ? $config['cache_path']
            : sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'purifier';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }
    }

}

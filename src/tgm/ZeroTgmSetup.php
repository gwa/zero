<?php

namespace Gwa\Wordpress\Template;

/**
*
*/
class ZeroTgmSetup
{
    /**
     * All added Plugins
     *
     * @type array
     */
    protected $plugins = [];

    /**
     * Set plugins
     *
     * @param array $plugins
     *
     * @return self
     */
    public function setPlugin(array $plugins)
    {
        $this->plugins = array_merge([

        ], $plugins);

        return $this;
    }

    /**
     * Get plugins
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->configs;
    }

    /**
     * Set configs
     *
     * @param array $configs
     *
     * @return self
     */
    public function setConfig(array $configs)
    {
        $this->config = array_merge([

        ], $configs);

        return $this;
    }

    /**
     * Get configs
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Init tgmpa class
     *
     * @return tgmpa
     */
    public function init()
    {
        tgmpa($this->getPlugins(), $this->getConfigs());
    }
}

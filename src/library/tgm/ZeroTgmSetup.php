<?php

namespace Gwa\Wordpress\Template\Zero\Library\Tgm;

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
     * Tgm config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Zero tgm setup.
     */
    public function __construct()
    {
        $this->setPlugin($this->standardPlugins());
        $this->setConfig($this->standardConfig());
    }

    /**
     * Set plugins
     *
     * @param array $plugins
     *
     * @return self
     */
    public function setPlugin(array $plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * Get plugins
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
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
        $this->config = $configs;

        return $this;
    }

    /**
     * Get configs
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->config;
    }

    /**
     * Init tgmpa class
     *
     * @return tgmpa
     */
    public function init()
    {
        foreach ($this->getPlugins() as $plugin) {
            TgmPluginActivation::$instance->register($plugin);
        }

        if ($this->getConfigs()) {
            TgmPluginActivation::$instance->config($this->getConfigs());
        }
    }

    /**
     * Standard tgm plugins
     *
     * @return array
     */
    public function standardPlugins()
    {
        $plugins = [
            [
                'name'               => 'timber',
                'slug'               => 'timber-library',
                'required'           => true,
            ],
            [
                'name'               => 'Timber clear cache', // The plugin name.
                'slug'               => 'timber-clear-cache', // The plugin slug (typically the folder name).
                'source'             => 'https://github.com/ogrosko/timber-clear-cache/archive/master.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'external_url'       => 'https://github.com/ogrosko/timber-clear-cache', // If set, overrides default API URL and points to an external URL.
            ],
            [
                'name'               => 'Soil', // The plugin name.
                'slug'               => 'soil', // The plugin slug (typically the folder name).
                'source'             => 'https://github.com/roots/soil/archive/master.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'external_url'       => 'https://roots.io/plugins/soil/', // If set, overrides default API URL and points to an external URL.
            ]
        ];

        return $plugins;
    }

    /**
     * Standard tgm configs
     *
     * @return array
     */
    public function standardConfig()
    {
        $pluginPath = defined('PLUGIN_DIR') ? PLUGIN_DIR : ABSPATH.'/wp-content/plugins/';

        $config = [
            'default_path' => $pluginPath,             // Default absolute path to pre-packaged plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            'strings'      => [
                'page_title'                      => __('Install Required Plugins', 'tgmpa'),
                'menu_title'                      => __('Install Plugins', 'tgmpa'),
                'installing'                      => __('Installing Plugin: %s', 'tgmpa'), // %s = plugin name.
                'oops'                            => __('Something went wrong with the plugin API.', 'tgmpa'),
                'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s).
                'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s).
                'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s).
                'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
                'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s).
                'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s).
                'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s).
                'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins'),
                'activate_link'                   => _n_noop('Begin activating plugin', 'Begin activating plugins'),
                'return'                          => __('Return to Required Plugins Installer', 'tgmpa'),
                'plugin_activated'                => __('Plugin activated successfully.', 'tgmpa'),
                'complete'                        => __('All plugins installed and activated successfully. %s', 'tgmpa'), // %s = dashboard link.
                'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            ]
        ];

        return $config;
    }
}

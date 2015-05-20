<?php

include_once get_template_directory().'/../vendor/autoload.php';

/**
 * Zero - a PHP 5.4 Wordpress Theme.
 *
 * @author      Daniel Bannert <bannert@greatwhiteark.com>
 * @copyright   2015 Great White Ark
 *
 * @link        http://www.greatwhiteark.com
 *
 * @license     MIT
 */

use Gwa\Wordpress\Template\Zero\Library\Soil\RootsSoil;
use Gwa\Wordpress\Template\Zero\Library\Tgm\ZeroTgmSetup;
use Gwa\Wordpress\Template\Zero\Library\Theme\ThemeSettings;

/**
 * Add needed theme plugins
 *
 * @var ZeroTgmSetup
 */
$tgm = new ZeroTgmSetup();

add_action('tgmpa_register', [$tgm, 'init']);


/**
 * Check if Timber is active.
 */
if (!class_exists('Timber')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="'.esc_url(admin_url('plugins.php#timber')).'">plugins page</a></p></div>';
    });

    return;
}

/**
 * Adds roots soil support to zero
 *
 * @link https://github.com/roots/soil
 */
if (class_exists('Roots\Soil\Options')) {
    $soil = new RootsSoil();

    $soil->init();
}

/**
 * Adds all global needed theme settings
 */
$theme = new ThemeSettings();

$theme->init();

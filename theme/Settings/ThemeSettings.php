<?php
namespace Gwa\Wordpress\Template\Zero\Settings;

/**
 * Zero Theme.
 *
 * @author      Daniel Bannert <bannert@greatwhiteark.com>
 * @copyright   2015 Great White Ark
 *
 * @link        http://www.greatwhiteark.com
 *
 * @license     MIT
 */

use Gwa\Wordpress\Template\Zero\Library\Theme\ThemeSettings as LibraryThemeSettings;

/**
 * Zero theme settings class.
 */
class ThemeSettings extends LibraryThemeSettings
{
    /**
     * Add to context
     *
     * @param array $data
     *
     * @return array
     */
    public function addToContext($data = [])
    {
        $context = [
        ];

        return array_merge($context, parent::addToContext($data));
    }

    /**
     * Makes Zero available for translation.
     *
     * Translations can be added to the /languages/ directory.
     * If you're building a theme based on Zero, use a find and replace
     * to change 'zero' to the name of your theme in all the template files.
     */
    public function addThemeLangSupport()
    {
        $this->getWpBridge()->loadThemeTextdomain('zero', get_template_directory() . '/languages');
    }

    /**
     * Init theme settings.
     */
    public function run()
    {
        $this->getWpBridge()->addAction('after_setup_theme', [$this, 'addThemeLangSupport']);

        // Should be allways last.
        parent::run();
    }
}

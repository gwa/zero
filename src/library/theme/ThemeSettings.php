<?php

namespace Gwa\Wordpress\Template\Zero\Library\Theme;

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

use TimberSite;
use TimberMenu;

/**
 * ThemeSettings.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
class ThemeSettings extends TimberSite
{
    /**
     * Add to context
     *
     * @param array
     *
     * @return array
     */
    public function addToContext($context) {
        $context['header-menu'] = new TimberMenu('header-menu');
        $context['footer-menu'] = new TimberMenu('footer-menu');

        $context['site'] = $this;

        $context         = $this->wpConditionals();

        return $context;
    }

    /**
     * Register Menus
     */
    public function registerMenuLocation()
    {
        register_nav_menus(
            [
              'header-menu' => __('Header Menu', 'zero'),
              'footer-menu' => __('Footer Menu', 'zero')
            ]
        );
    }

    /**
     * Init
     */
    public function init()
    {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');

        add_action('init', [$this, 'registerMenuLocation']);

        (new TwigFilter())->init();

        // Should be allways last.
        add_filter('timber_context', [$this, 'addToContext']);
    }

    /**
     * Wordpress conditionals
     *
     * @return array
     */
    protected function wpConditionals()
    {
        return [
            'is_home'              => is_home(),
            'is_front_page'        => is_front_page(),
            'is_admin'             => is_admin(),
            'is_single'            => is_single(),
            'is_sticky'            => is_sticky(),
            'get_post_type'        => get_post_type(),
            'is_single'            => is_single(),
            'is_post_type_archive' => is_post_type_archive(),
            //'comments_open'        => comments_open(),
            'is_page'              => is_page(),
            'is_page_template'     => is_page_template(),
            'is_category'          => is_category(),
            'is_tag'               => is_tag(),
            'has_tag'              => has_tag(),
            'is_tax'               => is_tax(),
            'has_term'             => has_term(),
            'is_author'            => is_author(),
            'is_date'              => is_date(),
            'is_year'              => is_year(),
            'is_month'             => is_month(),
            'is_day'               => is_day(),
            'is_time'              => is_time(),
            'is_archive'           => is_archive(),
            'is_search'            => is_search(),
            'is_404'               => is_404(),
            'is_paged'             => is_paged(),
            'is_attachment'        => is_attachment(),
            'is_singular'          => is_singular(),
            'template_uri'         => get_template_directory_uri(),
            'single_cat_title'     => single_cat_title(),
        ];
    }
}
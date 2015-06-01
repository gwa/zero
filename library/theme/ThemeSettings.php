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

use TimberMenu;
use TimberSite;

/**
 * ThemeSettings.
 *
 * @author  GWA
 *
 */
class ThemeSettings extends TimberSite
{
    /**
     * Add to context
     *
     * @param array $data
     *
     * @return array
     */
    public function addToContext($data)
    {
        $context = [];

        $context['header_menu'] = new TimberMenu('header-menu');
        $context['footer_menu'] = new TimberMenu('footer-menu');

        $context['site'] = $this;

        return array_merge($context, $data, $this->wpConditionals());
    }

    /**
     * Load all funcs after theme setup
     */
    public function afterSetupTheme()
    {
        load_theme_textdomain('zero', get_template_directory().'/languages');
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
     * WP_HEAD GOODNESS
     *
     * The default WordPress head is
     * a mess. Let's clean it up.
     */
    public function wpHeadCleanup()
    {
        // index link
        remove_action('wp_head', 'index_rel_link');
        // previous link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        // start link
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        // remove WP version from css
        add_filter('style_loader_src', [$this, 'removeWpVerCssJs'], 9999);
        // remove Wp version from scripts
        add_filter('script_loader_src', [$this, 'removeWpVerCssJs'], 9999);
    }

    /**
     * Remove WP version from RSS
     */
    public function removeRssVersion()
    {
        return '';
    }

    /**
     * remove WP version from scripts
     */
    public function removeWpVerCssJs($src)
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }

        return $src;
    }

    /**
     * Clean the output of attributes of images in editor.
     * Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
     *
     * @param string $class
     * @param string $id
     * @param string $align
     * @param string $size
     *
     * @return string
     */
    public function imageTagClassClean($class, $id, $align, $size)
    {
        $align = 'align'.esc_attr($align);
        return $align;
    }

    /**
     * Remove width and height in editor, for a better responsive world.
     *
     * @param string $html
     * @param string $id
     * @param string $alt
     * @param string $title
     *
     * @return string
     */
    public function imageEditorRemoveHightAndWidth($html, $id, $alt, $title)
    {
        return preg_replace([
                '/\s+width="\d+"/i',
                '/\s+height="\d+"/i',
                '/alt=""/i'
            ], [
                '',
                '',
                '',
                'alt="'.$title.'"'
            ], $html);
    }

    /**
     * Wrap images with figure tag.
     * Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
     *
     * @param string $figure
     *
     * @return string
     */
    public function wrapImgInFigure($figure)
    {
        $figure = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $figure);

        return $figure;
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
        add_action('init', [$this, 'wpHeadCleanup']);
        add_action('after_setup_theme', [$this, 'afterSetupTheme']);

        (new TwigFilter())->init();

        add_filter('the_generator', [$this, 'removeRssVersion']);
        add_filter('get_image_tag_class', [$this, 'imageTagClassClean'], 0, 4);
        add_filter('get_image_tag', [$this, 'imageEditorRemoveHightAndWidth'], 0, 4);
        add_filter('the_content', [$this, 'wrapImgInFigure'], 30);

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

<?php

namespace Gwa\Wordpress\Template\Zero\Library;

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

use Gwa\Wordpress\Template\Zero\Library\Timber\Post;
use LogicException;
use RuntimeException;
use Timber;
use TimberLoader;
use WP_Query;

/**
 * AbstractController.
 *
 * @author  GWA
 *
 */
abstract class AbstractController
{
    protected $cacheType = [
        'none'           => TimberLoader::CACHE_NONE,
        'object'         => TimberLoader::CACHE_OBJECT,
        'transient'      => TimberLoader::CACHE_TRANSIENT,
        'site.transient' => TimberLoader::CACHE_SITE_TRANSIENT,
        'default'        => TimberLoader::CACHE_USE_DEFAULT,
    ];

    /**
     * Cache expires time
     *
     * @var int
     */
    protected $cacheExpiresSecond;

    /**
     * Cache mode.
     *
     * @var string
     */
    protected $cacheMode = TimberLoader::CACHE_USE_DEFAULT;

    /**
     * WP_Query instance.
     *
     * @var \WP_Query
     */
    protected $wpQuery;

    /**
     * AbstractController instance.
     */
    public function __construct()
    {
        if (!class_exists('Timber')) {
            throw new RuntimeException(
                'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>'
            );
        }
    }

    /**
     * Set Wp_Query
     */
    public function setWpQuery(array $args)
    {
        $this->wpQuery = new WP_Query($args);
    }

    /**
     * Get Wp_Query
     *
     * @return \WP_Query
     */
    public function getWpQuery()
    {
        global $wp_query;
        return isset($this->wpQuery) ? $this->wpQuery : $wp_query;
    }

    /**
     * Set cache mode
     *
     * @param string  $mode
     *
     * @return self
     */
    public function setCacheMode($mode = 'default')
    {
        $this->cacheMode = $this->cacheType[$mode];

        return $this;
    }

    /**
     * Get cache mode
     *
     * @return \TimberLoader
     */
    public function getCacheMode()
    {
        return $this->cacheType[$this->cacheMode];
    }

    /**
     * Set cache expires seconds
     *
     * Timber will cache the template for 10 minutes (600 / 60 = 10).
     *
     * @param int $second
     *
     * @return self
     */
    public function setCacheExpiresSecond($second)
    {
        $this->cacheExpiresSecond = $second;

        return $this;
    }

    /**
     * Get cache expires seconds
     *
     * @return int
     */
    public function getCacheExpiresSecond()
    {
        return $this->cacheExpiresSecond;
    }

    /**
     * Get context
     *
     * @return array<string,\Timber|string>|null|array
     */
    abstract public function getContext();

    /**
     * Get template
     *
     * @return string[]
     */
    abstract public function getTemplates();

    /**
     * Get Post
     *
     * Works the same as AbstractController::addPostsToContext but limited to one post as the return object.
     *
     * @param null|string[] $args
     *
     * @return \Timber
     */
    public function getPost(array $args = null)
    {
        return Timber::get_post(($args !== null) ?: false, new Post());
    }

    /**
     * Get Posts
     *
     * @param null|string[] $args
     *
     * @return \Timber
     */
    public function getPosts(array $args = null)
    {
        return Timber::get_posts(($args !== null) ?: false, new Post());
    }

    /**
     *  Render template
     *
     * @return boolean|string|null
     */
    public function render()
    {
        $this->validateTemplates($this->getTemplates());
        $this->validateContext($this->getContext());

        Timber::render(
            $this->getTemplates(),
            array_merge(Timber::get_context(), $this->getContext()),
            // False disables cache altogether.
            ($this->getCacheExpiresSecond() ?: false),
            $this->getCacheMode()
        );
    }

    /**
     * Check if context is a array
     *
     * @param array|null $context
     */
    protected function validateContext($context)
    {
        if (!is_array($context)) {
            throw new LogicException('::getContext should return a array');
        }
    }

    /**
     * Check if getTemplates is a array and template file exist
     *
     * @param string[] $templates
     */
    protected function validateTemplates($templates)
    {
        if (!is_array($templates)) {
            throw new LogicException('::getTemplates should return a array');
        }

        foreach ($templates as $template) {
            if (!is_file(get_template_directory().'/views/'.$template) && !is_file(get_template_directory().'/views/'.end($templates))) {
                throw new LogicException(sprintf('Template [%s] dont exists.', $template));
            }
        }
    }
}

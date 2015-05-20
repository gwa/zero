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
use RuntimeException;
use Timber;
use TimberLoader;

/**
 * AbstractController.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
abstract class AbstractController
{
    protected $cacheType = [
        'none'           => TimberLoader::CACHE_NONE,
        'object'         => TimberLoader::CACHE_OBJECT,
        'transiete'      => TimberLoader::CACHE_TRANSIENT,
        'site.transiete' => TimberLoader::CACHE_SITE_TRANSIENT,
        'default'        => TimberLoader::CACHE_USE_DEFAULT,
    ];

    /**
     * Template Name
     *
     * @var array
     */
    protected $templates = [];

    /**
     * File context
     *
     * @var array
     */
    protected $context = [];

    /**
     * Add posts to context
     *
     * @var boolean
     */
    protected $activePosts = true;

    /**
     * Add post to context
     *
     * @var boolean
     */
    protected $activePost = false;

    /**
     * Posts args
     *
     * @var array|boolean
     */
    protected $postsArgs = false;

    /**
     * Posts args
     *
     * @var array|boolean
     */
    protected $postArgs = false;

    /**
     * Cache expires time
     *
     * @var bool|int
     */
    protected $cacheExpires = false;

    /**
     * Cache mode.
     *
     * @var string
     */
    protected $cacheMode = TimberLoader::CACHE_USE_DEFAULT;

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
     * Add posts to context
     *
     * @param boolean $active
     * @param array|boolean $paramname description
     *
     * @return self
     */
    public function addPostsToContext($active = true, array $args = false)
    {
        $this->activePosts = $active;
        $this->postsArgs   = $args;

        return $this;
    }

    /**
     * Add post to context
     *
     * Works the same as AbstractController::addPostsToContext but limited to one post as the return object.
     *
     * @param boolean $active
     * @param array|boolean $paramname description
     *
     * @return self
     */
    public function addPostToContext($active = true, array $args = false)
    {
        $this->activePost = $active;
        $this->postArgs  = $args;

        return $this;
    }

    public function setCache($expires = false, $mode = 'default')
    {
        $this->cacheExpires = $expires;
        $this->cacheMode    = $this->cacheType[$mode];
    }

    /**
     * Set context for template
     *
     * @return self
     */
    public function setContext(array $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @param false|string $key
     *
     * @return array
     */
    public function getContext($key = false)
    {
        $context = Timber::get_context();

        if ($this->activePosts) {
            $context['posts'] = Timber::get_posts($this->postsArgs, new Post());
        } elseif ($this->activePost) {
            $context['post']  = Timber::get_post($this->postsArgs, new Post());
        }

        $data = array_merge($context, $this->context);

        if ($key) {
            return $data[$key];
        }

        return $data;
    }

    /**
     * Set template
     *
     * @param array $templates
     *
     * @return self
     */
    public function setTemplate(array $templates)
    {
        $templates       = $this->checkIfTemplateExist($templates);

        $this->templates = $templates;

        return $this;
    }

    /**
     * Get template
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
    *  Render template
    *
     * @return boolean|string|null
     */
    public function render()
    {
        Timber::render($this->getTemplates(), $this->getContext(), $this->cacheExpires, $this->cacheMode);
    }

    /**
     * Check if file exist
     *
     * @param array $templates
     *
     * @return string
     */
    protected function checkIfTemplateExist($templates)
    {
        foreach ($templates as $template) {
            if (!is_file(get_template_directory().'/views/'.$template)) {
                return 'error-template.twig';
            }
        }

        return $templates;
    }
}

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

/**
 * AbstractController.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
abstract class AbstractController implements PageControllerContract
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
     * Init Cache
     *
     * @param boolean $expires
     * @param string  $mode
     *
     * @return self
     */
    public function initCache($expires = false, $mode = 'default')
    {
        $this->cacheExpires = $expires;
        $this->cacheMode    = $this->cacheType[$mode];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getContext();

    /**
     * {@inheritdoc}
     */
    abstract public function getTemplates();

    /**
     * Get Post
     *
     * Works the same as AbstractController::addPostsToContext but limited to one post as the return object.
     *
     * @param array|boolean $args
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
     * @param array|boolean $args
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
            $this->cacheExpires,
            $this->cacheMode
        );
    }

    /**
     * Check if context is a array
     *
     * @param array $context
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
     * @param array $templates
     */
    protected function validateTemplates($templates)
    {
        if (!is_array($templates)) {
            throw new LogicException('::getTemplates should return a array');
        }

        // foreach ($templates as $template) {
        //     if (!is_file(get_template_directory().'/views/'.$template)) {
        //         throw new LogicException(sprintf('Template [%s] dont exists.', $template));
        //     }
        // }
    }
}

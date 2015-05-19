<?php

namespace Gwa\Wordpress\Template\Zero\Library\Controller;

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

use TimberHelper;
use Gwa\Wordpress\Template\Zero\Library\AbstractController;

/**
 * Single.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
class Single extends AbstractController
{
    /**
     * Add posts to context
     *
     * @var boolean
     */
    protected $activePosts   = false;

    /**
     * Add post to context
     *
     * @var boolean
     */
    protected $activePost    = true;

    public function __construct()
    {
        parent::__construct();

        $post = $this->getContext('post');

        $this->setContext($this->singleData($post));

        if (post_password_required($post->ID)) {
            $template = ['single-password.twig'];
        } else {
            $template = ['single-'.$post->ID.'.twig', 'single-'.$post->post_type.'.twig', 'single.twig')];
        }

        $this->setTemplate($template);
    }

    /**
     * Needed single data
     *
     * @param WP_Post $post
     *
     * @return array
     */
    protected function singleData($post)
    {
        $data['post']         = $post;
        $data['wp_title']    .= ' - ' . $post->title();
        $data['comment_form'] = TimberHelper::get_comment_form();

        return $data;
    }
}

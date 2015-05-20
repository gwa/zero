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
final class Single extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        $post = $this->getContext('post');

        $this->addPostToContext(true);
        $this->addPostsToContext(false);

        $this->setContext($this->singleData($post));

        $this->setTemplate($this->templateToRender($post));
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
        $data['wp_title']    .= ' - '.$post->title();
        $data['comment_form'] = TimberHelper::get_comment_form();

        return $data;
    }

    /**
     * Template to render
     *
     * @param WP_Post $post
     *
     * @return array
     */
    protected function templateToRender($post)
    {
        if (post_password_required($post->ID)) {
            return ['single-password.twig'];
        }

        return ['single-'.$post->ID.'.twig', 'single-'.$post->post_type.'.twig', 'single.twig')];
    }
}

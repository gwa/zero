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

use Gwa\Wordpress\Template\Zero\Library\AbstractController;
use TimberHelper;

/**
 * Single.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Single extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        $post                 = $this->getPost();

        $data                 = [];
        $data['post']         = $post;
        $data['wp_title']     = ' - '.$post->title();
        $data['comment_form'] = TimberHelper::get_comment_form();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        $post = $this->getPost();

        if (post_password_required($post->ID)) {
            return ['single-password.twig'];
        }

        return ['single-'.$post->ID.'.twig', 'single-'.$post->post_type.'.twig', 'single.twig'];
    }
}

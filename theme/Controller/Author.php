<?php

namespace Gwa\Wordpress\Template\Zero\Controller;

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
use Timber;
use TimberUser;
use WP_Query;

/**
 * Author.
 *
 * @author  GWA
 *
 */
final class Author extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        $wpQuery = $this->getWpQuery();

        $data = [];

        if (isset($wpQuery->query_vars['author'])) {
            $author = new TimberUser($wpQuery->query_vars['author']);
            $data['author'] = $author;
            $data['title']  = 'Author Archives: '.$author->name();
        }

        $data['pagination'] = Timber::get_pagination();
        $data['posts']      = $this->getPosts();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return ['author.twig', 'archive.twig'];
    }
}

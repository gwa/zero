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
use Timber;
use TimberUser;

/**
 * Author.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Author extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        $this->setContext($this->authorData());

        $this->setTemplate(['author.twig', 'archive.twig']);
    }

    /**
     * Needed author data
     *
     * @return array
     */
    protected function authorData()
    {
        global $wp_query;

        if (isset($wp_query->query_vars['author'])) {
            $author = new TimberUser($wp_query->query_vars['author']);
            $data['author'] = $author;
            $data['title']  = 'Author Archives: '.$author->name();
        }

        $data['pagination'] = Timber::get_pagination();

        return $data;
    }
}

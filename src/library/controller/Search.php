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

/**
 * Search.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Search extends AbstractController
{
    /**
     * Get context
     *
     * @return array
     */
    public function getContext()
    {
        return [
            'posts' => $this->getPosts(),
            'title' => 'Search results for '.get_search_query()
        ];
    }

    /**
     * Get templates
     *
     * @return array
     */
    public function getTemplates()
    {
        return ['search.twig', 'archive.twig', 'index.twig'];
    }
}

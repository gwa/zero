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
 * Home.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Home extends AbstractController
{
    /**
     * Get context
     *
     * @return array
     */
    public function getContext()
    {
        return ['posts' => $this->getPosts()];
    }

    /**
     * Get templates
     *
     * @return string[]
     */
    public function getTemplates()
    {
        if (is_home()) {
            return ['home.twig'];
        }

        return ['index.twig'];
    }
}

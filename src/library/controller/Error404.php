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
 * Error404.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Error404 extends AbstractController
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
     * @return array
     */
    public function getTemplates()
    {
        $this->setTemplate(['error-404.twig']);
    }
}

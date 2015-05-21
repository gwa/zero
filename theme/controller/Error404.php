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

/**
 * Error404.
 *
 * @author  GWA
 *
 */
final class Error404 extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return ['posts' => $this->getPosts()];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return ['error-404.twig'];
    }
}

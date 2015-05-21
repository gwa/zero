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
 * Sidebar.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Sidebar extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return ['sidebar.twig'];
    }
}

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
 * Home.
 *
 * @author  GWA
 *
 */
final class Footer extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return['content' => ob_get_contents()];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return ['page-plugin.twig'];
    }
}

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
 * Page.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
final class Page extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        $this->addPostToContext(true);
        $this->addPostsToContext(false);

        $this->setTemplate(['page-'.$this->getContext('post')->post_name.'.twig', 'page.twig']);
    }
}

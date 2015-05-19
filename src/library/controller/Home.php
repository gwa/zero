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
class Home extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (is_home()) {
            $this->setTemplate(['home.twig']);
        } else {
            $this->setTemplate(['index.twig']);
        }
    }
}

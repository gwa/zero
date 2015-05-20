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
final class Footer extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        $this->setContext($this->footerData());

        $this->setTemplate(['page-plugin.twig']);
    }

    /**
     * Needed footer data
     *
     * @return array<string,string>
     */
    protected function footerData()
    {
        $data = $GLOBALS['timberContext'];

        if (!isset($data)) {
            throw new \Exception('Timber context not set in footer.');
        }

        $data['content'] = ob_get_contents();

        return $data;
    }
}

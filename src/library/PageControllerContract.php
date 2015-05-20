<?php

namespace Gwa\Wordpress\Template\Zero\Library;

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

/**
 * PageControllerContract.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
interface PageControllerContract
{
    /**
     * Get context
     *
     * @return array
     */
    public function getContext();

    /**
     * Get template
     *
     * @return array
     */
    public function getTemplates();
}

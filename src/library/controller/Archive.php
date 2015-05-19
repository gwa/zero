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
 * Archive.
 *
 * @author  Daniel Bannert
 *
 * @since   0.0.1-dev
 */
class Archive extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        $data = $this->archiveData(['archive.twig', 'index.twig']);

        $this->setContext($data['data']);

        $this->setTemplate($data['templates']);
    }

    /**
     * Needed archive title
     *
     * @return array
     */
    protected function archiveData(array $templates)
    {
        $data['title']     = 'Archive';

        if (is_day()) {
            $data['title'] = 'Archive: '.get_the_date('D M Y');
        } elseif (is_month()) {
            $data['title'] = 'Archive: '.get_the_date('M Y');
        } elseif (is_year()) {
            $data['title'] = 'Archive: '.get_the_date('Y');
        } elseif (is_tag()) {
            $data['title'] = single_tag_title('', false);
        } elseif (is_category()) {
            $data['title'] = single_cat_title('', false);
            array_unshift($templates, 'archive-'.get_query_var('cat').'.twig');
        } elseif (is_post_type_archive()) {
            $data['title'] = post_type_archive_title('', false);
            array_unshift($templates, 'archive-'.get_post_type().'.twig');
        }

        return [
            'data'      => $data,
            'templates' => $templates
        ];
    }
}

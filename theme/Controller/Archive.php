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
 * Archive.
 *
 * @author  GWA
 *
 */
final class Archive extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        $data               = [];

        $data['posts']      = $this->getPosts();
        $data['title']      = __('Archive', 'zero');

        if (is_day()) {
            $data['title']  = __('Archive: ', 'zero').get_the_date('D M Y');
        } elseif (is_month()) {
            $data['title']  = __('Archive: ', 'zero').get_the_date('M Y');
        } elseif (is_year()) {
            $data['title']  = __('Archive: ', 'zero').get_the_date('Y');
        } elseif (is_tag()) {
            $data['title']  = single_tag_title('', false);
        } elseif (is_category()) {
            $data['title']  = single_cat_title('', false);
        } elseif (is_post_type_archive()) {
            $data['title']  = post_type_archive_title('', false);
        }

        $data['pagination'] = \Timber::get_pagination();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        $templates = ['archive.twig'];

        if (is_category()) {
            array_unshift($templates, 'archive-'.get_query_var('cat').'.twig');
        } elseif (is_post_type_archive()) {
            array_unshift($templates, 'archive-'.get_post_type().'.twig');
        }

        return $templates;
    }
}

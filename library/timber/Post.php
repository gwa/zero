<?php

namespace Gwa\Wordpress\Template\Zero\Library\Timber;

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

use TimberPost;

/**
 * Post.
 *
 * @author  GWA
 *
 */
class Post extends TimberPost
{
    public function get_edit_url()
    {
        return ($this->can_edit() ? get_edit_post_link($this->ID) : false);
    }

    /**
     * @param  string $date_format
     *
     * @return string
     */
        public function get_date($date_format = '')
        {
            $df = $date_format ? $date_format : get_option('date_format');
            $the_date = (string) mysql2date($df, $this->post_date);

            return apply_filters('get_the_date', $the_date, $date_format);
        }

        /**
         * @param  string $date_format
         * @return string
         */
        public function get_modified_date($date_format = '')
        {
            $df = $date_format ? $date_format : get_option('date_format');
            $the_time = $this->get_modified_time($df, null, $this->ID, true);

            return apply_filters('get_the_modified_date', $the_time, $date_format);
        }

        /**
         * @param string $time_format
         *
         * @return string
         */
        public function get_modified_time($time_format = '')
        {
            $tf = $time_format ? $time_format : get_option('time_format');
            $the_time = get_post_modified_time($tf, false, $this->ID, true);

            return apply_filters('get_the_modified_time', $the_time, $time_format);
        }

        /**
         * @return string
         */
        public function date($date_format = '')
        {
            return $this->get_date($date_format);
        }

        /**
         * @return string
         */
        public function modified_date($date_format = '')
        {
            return $this->get_modified_date($date_format);
        }
}

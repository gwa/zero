<?php

namespace Gwa\Wordpress\Template\Helper;

class PublicHelper
{
    /**
     * Set the base of the author permalink
     *
     * PublicHelper::setAuthorBase('writers');
     *
     * @param string  $base
     * @param boolean $withFront
     */
    public function setAuthorBase($base, $withFront = true) {
        global $wp_rewrite;

        $wp_rewrite->author_base = $base;

        if (!$withFront) {
            $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
        }
    }

    /**
     * Set a custom permalink
     *
     * PublicHelper::setPermalink('gallery', '/galleries/%year%/%gallery%');
     *
     * @param string $postType
     * @param string $struc
     *
     */
    public function setPermalink($postType, $struc) {
        global $wp_rewrite;

        $galleryStructure = $struc;

        $wp_rewrite->add_rewrite_tag("%".$postType."%", '([^/]+)', $postType."=");
        $wp_rewrite->add_permastruct($postType, $galleryStructure, false);

        add_filter('post_type_link', [$this, 'postTypePermalink'], 10, 3);
    }

    public function setSearchPermalink($base = 'search') {
        add_action(
            'template_redirect',
            function () use ($base) {
                if (is_search() && ! empty($_GET['s'])) {
                    wp_redirect(('/'.$base.'/') . urlencode(get_query_var('s')));
                    exit();
                }
            }
        );
    }

    public function addCptToAuthors($cptSlugs) {
        add_action(
            'pre_get_posts',
            function(&$query) use ($cptSlugs) {
                if ($query->is_author) {
                    $query->set('post_type', $cptSlugs);
                }
            }
        );
    }

    /**
     * Remove a custom post type permalink
     *
     * PublicHelper::removePermalinkSlug('event');
     * PublicHelper::removePermalinkSlug(['event', 'book', 'my_other_cpt']);
     *
     * @param sting|array $cptSlugs
     */
    public function removePermalinkSlug($cptSlugs) {
        if (is_string($cptSlugs)) {
            $cptSlugs = [$cptSlugs];
        }

        $removedPermalinkSlugs = [];

        if (isset($GLOBALS['removed_permalink_slugs'])) {
            $removedPermalinkSlugs = $GLOBALS['removed_permalink_slugs'];
        }

        if (is_array($removedPermalinkSlugs)) {
            $removedPermalinkSlugs = array_merge($removedPermalinkSlugs, $cptSlugs);
        } else {
            $removedPermalinkSlugs = $cptSlugs;
        }

        $GLOBALS['removed_permalink_slugs'] = $removedPermalinkSlugs;

        if (!has_filter('post_type_link', [$this, 'removePermalinkSlugPostTypeLink'])) {
            add_filter('post_type_link', [$this, 'removePermalinkSlugPostTypeLink'], 10, 3);
        }

        if (!has_action('pre_get_posts', [$this, 'removePermalinkSlugPreGetPosts'])) {
            add_action('pre_get_posts', [$this, 'removePermalinkSlugPreGetPosts']);
        }
    }

    protected function removePermalinkSlugPostTypeLink($postLink, $post, $leavename) {
        $postTypes = $GLOBALS['removed_permalink_slugs'];

        if (! in_array($post->post_type, $postTypes) || 'publish' != $post->post_status) {
            return $postLink;
        }

        $postLink = str_replace('/' . $post->post_type . '/', '/', $postLink);

        return $postLink;
    }

    protected function removePermalinkSlugPreGetPosts($query) {
        $postTypes = $GLOBALS['removed_permalink_slugs'];
        $postTypes[] = 'page';
        $postTypes[] = 'post';

        if (!$query->is_main_query()) {
            return;
        }

        // Only noop our very specific rewrite rule match
        if (2 !== count($query->query) || !isset($query->query['page'])) {
            return;
        }

        // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
        if (!empty($query->query['name']) || !empty($query->query['pagename'])) {
            $query->set('post_type', $postTypes);
        }
    }

    protected function postTypePermalink($permalink, $post_id, $leavename) {
        $post        = get_post($post_id);

        $rewritecode = [
            '%year%',
            '%monthnum%',
            '%day%',
            '%hour%',
            '%minute%',
            '%second%',
            $leavename? '' : '%postname%',
            '%post_id%',
            '%category%',
            '%author%',
            $leavename? '' : '%pagename%',
        ];

        if ($permalink !== '' && !in_array($post->post_status, ['draft', 'pending', 'auto-draft'])) {
            $unixtime = strtotime($post->post_date);
            $category = '';

            if (strpos($permalink, '%category%') !== false) {
                $cats = get_the_category($post->ID);

                if ($cats) {
                    usort($cats, '_usort_terms_by_ID'); // order by ID
                    $category = $cats[0]->slug;

                    if ($parent = $cats[0]->parent) {
                        $category = get_category_parents($parent, false, '/', true).$category;
                    }
                }

                // show default category in permalinks, without
                // having to assign it explicitly
                if (empty($category)) {
                    $default_category = get_category(get_option('default_category'));
                    $category         = is_wp_error($default_category) ? '' : $default_category->slug;
                }
            }

            $author = '';

            if (strpos($permalink, '%author%') !== false) {
                $authordata = get_userdata($post->post_author);
                $author     = $authordata->user_nicename;
            }

            $date = explode(' ', date('Y m d H i s', $unixtime));

            $rewritereplace = [$date[0], $date[1], $date[2], $date[3], $date[4], $date[5], $post->post_name, $post->ID, $category, $author, $post->post_name,];

            $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
        }

        return $permalink;
    }
}

<?php

namespace Gwa\Wordpress\Template\Helper;

class AdminHelper
{
    /**
     * Add a Js file to the admin
     *
     * @param string $file
     */

    public function addJs($file)
    {
        $this->addAdminJsorCss($file);
    }

    /**
     * Add a CSS file to the admin
     *
     * @param string $file
     */
    public function addCss($file)
    {
        $this->addAdminJsorCss($file);
    }

    /**
     * Show an admin notice
     *
     * @param string $text
     * @param string $class
     */
    public function showNotice($text, $class = 'updated') {
        if ($class == 'yellow') {
            $class = 'updated';
        }

        if ($class == 'red') {
            $class = 'error';
        }

        add_action(
            'admin_notices',
            function () use ($text, $class) {
                echo '<div class="'.$class.'"><p>'.$text.'</p></div>';
            },
            1
        );
    }

    /**
     * Add a dropdown
     *
     * $optionOne = new stdClass();
     * $optionOne->label = 'All Caches';
     * $optionOne->action = function(){
     *     $totalCache->flushAll()
     * };
     *
     * $optionTwo = new stdClass();
     * $optionTwo->label = 'Page Cache';
     * $optionTwo->action = function(){
     *     $totalCache->flushPageCache();
     * };
     *
     * $optionThree = ['Home', 'http://localhost'];
     *
     * AdminHelper::addToolbarGroup('Clear Cache', array($optionOne, $optionTwo, $optionThree));
     *
     * @param string $label
     * @param array  $items
     */
    public function addToolbarGroup($label, array $items) {
        add_action(
            'admin_bar_menu',
            function ($wp_admin_bar) use ($label) {
                $args = [
                    'id'    => sanitize_title($label),
                    'title' => $label
                ];
                $wp_admin_bar->add_node($args);
            },
            9999
        );

        foreach ($items as $item) {
            if (is_array($item) && count($item == 2)) {
                $array_item = $item;
                $item = new stdClass();
                $item->label = $array_item[0];
                $item->action = $array_item[1];
            }

            self::add_toolbar_item($item->label, $item->action, sanitize_title($label));
        }
    }

    public function addBarItem($label, $urlOrCallback, $parent = false) {
        $href = $urlOrCallback;
        $slug = sanitize_title($label);

        if (!is_string($href)) {
            //its a callback
            $href = '?gwa-function='.$slug;

            if (!isset($GLOBALS['gwaFunctions'])) {
                $GLOBALS['gwaFunctions'] = [];
            }

            $GLOBALS['gwaFunctions'][$slug] = $urlOrCallback;
        }

        add_action(
            'admin_bar_menu',
            function($wp_admin_bar) use ($label, $slug, $href, $parent) {
                $args = ['id' => $slug,
                    'title' => __($label ),
                    'href' => $href
                ];
                if ($parent) {
                    $args['parent'] = $parent;
                }
                $wp_admin_bar->add_menu($args);
            },
            9999
        );

        add_action(
            'init',
            function() use ($slug) {
                if (isset($_GET['gwa-function'])) {
                    $func_name = $_GET['gwa-function'];

                    if ($func_name != $slug) {
                        //only run actual function if that get is set.
                        return;
                    }

                    $gwaFunctions = $GLOBALS['gwaFunctions'];

                    if (isset($gwaFunctions[$func_name])) {
                        $callback = $gwaFunctions[$func_name];

                        if ($callback) {
                            $callback();
                        }
                    }
                }
            }
        );
    }

    protected function addAdminJsorCss($file, $function = 'wp_enqueue_style')
    {
        if (!is_admin()) {
            return;
        }

        if (!file_exists(ABSPATH.$file)) {
            $file = trailingslashit(get_template_directory_uri()).$file;
        }

        add_action(
            'admin_enqueue_scripts',
            function () use ($file, $function) {
                $function(sanitize_title($file), $file);
            }
        );
    }
}

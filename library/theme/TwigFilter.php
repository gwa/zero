<?php

namespace Gwa\Wordpress\Template\Zero\Library\Theme;

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

use Twig_SimpleFunction;

/**
 * Post.
 *
 * @author  GWA
 *
 */
class TwigFilter
{
    /**
     * Translation functions
     *
     * @param Twig $twig
     */
    public function addTranslationFunctions($twig)
    {
        $twig->addFunction('_x', new Twig_SimpleFunction('_x',
                function ($text, $context, $domain = 'default') {
                    return _x($text, $context, $domain);
                }
        ));

        $twig->addFunction('_n', new Twig_SimpleFunction('_n',
                function ($single, $plural, $number, $domain = 'default') {
                    return _n($single, $plural, $number, $domain);
            }
        ));

        $twig->addFunction('_nx', new Twig_SimpleFunction('_nx',
            function ($single, $plural, $number, $context, $domain = 'default') {
                return _nx($single, $plural, $number, $context, $domain);
            }
        ));

        return $twig;
    }

    /**
     * Add filter
     */
    public function init()
    {
        add_action('twig_apply_filters', [$this, 'addTranslationFunctions']);
    }
}

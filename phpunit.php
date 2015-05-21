<?php

if (file_exists($composer_autoload = __DIR__ . '/../vendor/autoload.php')) {
    require_once($composer_autoload);
}

$testsDir = getenv('WP_TESTS_DIR');

if (!$testsDir) {
    $testsDir = '/tmp/wordpress-tests-lib';
}

require_once $testsDir . '/includes/functions.php';

function manuallyLoadPlugin()
{
    require dirname(__FILE__) . '/../wp-content/plugins/timber/timber.php';
}

tests_add_filter('muplugins_loaded', 'manuallyLoadPlugin');
require $testsDir . '/includes/bootstrap.php';

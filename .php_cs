<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('README.md')
    ->notName('composer.*')
    ->notName('.scrutinizer.yml')
    ->notName('.travis.yml')
    ->notName('.php_cs')
    ->notName('rtl.css')
    ->notName('style.css')
    ->notName('screenshot.png')
    ->exclude('vendor')
    ->exclude('tests')
    ->exclude('wp-content')
    ->exclude('views')
    ->exclude('languages')
    ->exclude('assets')
    ->exclude('tasks')
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    // use default PSR-2_LEVEL:
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers(
        [
            'ordered_use',
            'short_array_syntax',
            'strict',
            'strict_param',
            'phpdoc_order',
        ]
    )
    ->finder($finder);

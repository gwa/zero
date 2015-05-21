# Zero Wordpress Starter theme with using Timber

![Zero](https://github.com/gwa/zero/blob/master/zero-header.jpg)

## Description

This is a WordPress starter theme. This theme differs from the rest as it makes use to the fantastic [Timber Library](http://upstatement.com/timber/) allowing you to use the [Twig templating](http://twig.sensiolabs.org/) language. Timber facilitates a separation of concerns in Wordpress splitting the data and view of your project.

Make sure to fork! If you do, you get a cookie.

## Requirements

* php 5.4
* [Composer](https://getcomposer.org/)
* [Timber Library](http://upstatement.com/timber/)
* (Optional) [Soil](https://github.com/roots/soil)

## Installation

To get the latest version of Zero theme, simply add the following line to the require block of your `composer.json` file:

~~~json
{
    "require": {
        "gwa/zero" : "~1.0.0"
    }
}
~~~

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

## License
Zero theme is licensed under [The MIT License (MIT)](https://github.com/gwa/zero/blob/master/LICENSE).
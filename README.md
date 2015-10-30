# Zero Wordpress Starter theme using Timber

![Zero](https://github.com/gwa/zero/blob/master/zero-header.jpg)

## Description

This is a WordPress starter theme. This theme differs from the rest as it makes use to the fantastic [Timber Library](http://upstatement.com/timber/) allowing you to use the [Twig templating](http://twig.sensiolabs.org/) language. Timber facilitates a separation of concerns in Wordpress splitting the data and view of your project.

Make sure to fork! If you do, you get a cookie.

## Requirements

* php 5.4
* [nodejs](https://nodejs.org/en/)
* [grunt](http://gruntjs.com/)
* [Composer](https://getcomposer.org/)
* [Zero Library](https://github.com/gwa/zero-library)

## Installation

To get the latest version of Zero theme, simply [download zero](https://github.com/gwa/zero/archive/3.0.zip), unzip it to your wordpress theme folder and add the following line to the require block of your `composer.json` file:

~~~json
{
    "require": {
        "gwa/zero-library" : "~3.3.0"
    }
}
~~~

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated and `npm install` to start working with Grunt.

If you make some changes on gettext `__() or {{ __() }}` funtions, you need to run grunt in your console.

## License
Zero theme is licensed under [The MIT License (MIT)](https://github.com/gwa/zero/blob/master/LICENSE).
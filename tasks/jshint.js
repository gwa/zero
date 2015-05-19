'use strict';
//jshint config

module.exports = {
    options: {
        jshintrc: '.jshintrc',
        reporter: require('jshint-stylish')
    },
    dev: [
        'Gruntfile.js',
        'grunt/*.js',
        'lib/*.js',
        'test/*.js'
    ]
};
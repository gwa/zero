module.exports = {
    'dev:test' : [
        'newer:jsonlint:dev',
        //'newer:jshint:dev',
        'newer:jsvalidate:dev'
    ],
    'default': [
        'newer:jsonlint',
        'newer:jshint'
    ],
    'build': [
        'newer:lint'
    ]
};
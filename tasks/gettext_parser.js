'use strict';
//gettext_parser config

module.exports = {
  zero: {
    options: {
      textdomain: 'zero',
    },
    files: {
      'theme/languages/zero-gettext.php': [
          'theme/views/**/*.twig'
      ]
    }
  }
};

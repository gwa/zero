'use strict';
//pot config

module.exports = {
  options:{
      text_domain: 'zero', //Your text domain. Produces my-text-domain.pot
      encoding: 'UTF-8',
      dest: 'theme/languages/', //directory to place the pot file
      keywords: ['__'], //functions to look for
      msgmerge: true // update po files
  },
  files:{
      src:  ['theme/**/*.php'], //Parse all php files
      expand: true,
  }
};

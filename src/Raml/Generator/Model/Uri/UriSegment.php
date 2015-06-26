<?php

namespace DeLois\Raml\Generator\Model\Uri;

use DeLois\Raml\Generator\Model\AbstractUri;

class UriSegment extends AbstractUri {

  const PARAM_VERSION = 'version';


  protected function _validate( $uri ) {

    // Needs to start with an opening "/"
    // Should also ensure that there are valid characters in it.
    // Stupid validation for now:
    return strpos( $uri, '/' ) === 0;

  }


  protected function _getFormatDescripton() {

    return 'Uri must contain only valid characters [alphaNumeric] and begin with a leading slash ("/").';

  }

}

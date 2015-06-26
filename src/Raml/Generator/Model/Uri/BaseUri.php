<?php

namespace DeLois\Raml\Generator\Model\Uri;

use DeLois\Raml\Generator\Model\AbstractUri;

class BaseUri extends AbstractUri {

  protected function _validate( $uri ) {

    // TODO: Validate for https://www.ietf.org/rfc/rfc2396.txt - URI Format
    // TODO: Validate for https://tools.ietf.org/html/rfc6570 - URI Template Format
    // Stupid validation for now:
    return strpos( $uri, 'http' ) === 0;

    // TODO: Might make sense to throw an exception if there is no {version} set
    //  in the API, yet the $base_uri template provides one

  }


  protected function _getFormatDescripton() {

    return 'Uri must be absolute (http, https, etc) conforming to RFC2396 or templated in conjunction with RFC6570.';

  }

}

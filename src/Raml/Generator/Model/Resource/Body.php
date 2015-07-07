<?php

namespace DeLois\Raml\Generator\Model\Resource;

use DeLois\Raml\Generator\Model\AbstractNamedParameter;

class Body {

  const MEDIA_TYPE_FORM      = 'application/x-www-form-urlencoded';
  const MEDIA_TYPE_MULTIPART = 'multipart/form-data';
  const MEDIA_TYPE_JSON      = 'application/json';

  private $_media_type;

  private $_example;

  private $_parameters = [];

  public function __construct( $media_type = self::MEDIA_TYPE_FORM ) {

    $this->_media_type = $media_type;

  }

  public function getMediaType() {

    return $this->_media_type;

  }

  public function addExample( /*Example*/ $example ) {

    $this->_example = $example;
    return $this;

  }

  public function getExample() {

    return $this->_example;

  }

  public function addParameter( AbstractNamedParameter $parameter ) {

    $this->_parameters[ $parameter->getName() ] = $parameter;
    return $this;

  }

  /**
   * @param AbstractNamedParameter[] $parameters
   *
   * @return Body
   */
  public function setParameters( array $parameters ) {

    $this->_parameters = $parameters;
    return $this;

  }

  public function getParameters() {

    return $this->_parameters;

  }

}

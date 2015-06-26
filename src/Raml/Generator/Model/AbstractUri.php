<?php

namespace DeLois\Raml\Generator\Model;

abstract class AbstractUri {

  protected $_uri;

  protected $_parameters = [];

  public function __construct( $uri ) {

    if ( !$this->_validate( $uri ) ) {
      throw new \InvalidArgumentException( sprintf( 'Invalid URI "%s": %s.', $uri, $this->_getFormatDescripton() ) );
    }
    $this->_uri = $uri;

  }

  public function __toString() {

    return $this->_uri;

  }

  public function addParameter( AbstractNamedParameter $parameter ) {

    $key = $parameter->getName();

    $token = $this->_tokenizeParameterKey( $key );

    if ( strpos( $this->_uri, $token ) === false ) {
      throw new \InvalidArgumentException( sprintf( 'No param "%s" found in URI "%s"', $token, $this->_uri ) );
    }

    $this->_parameters[ $key ] = $parameter;

    return $this;

  }

  public function addParameters( array $parameters ) {

    foreach( $parameters as $parameter ) {
      $this->addParameter( $parameter );
    }

    return $this;

  }

  public function getParameters() {

    return $this->_parameters;

  }

  private function _tokenizeParameterKey( $key ) {

    return "{{$key}}";

  }

  abstract protected function _validate( $uri );

  abstract protected function _getFormatDescripton();

}

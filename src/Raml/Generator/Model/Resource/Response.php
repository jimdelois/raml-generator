<?php

namespace DeLois\Raml\Generator\Model\Resource;

class Response {

  private $_code;

  private $_description;

  private $_bodies = [];

  private $_headers = [];


  public function __construct( $code, $description = null ) {

    if ( !\Improv\Http\Response\Code::isValid( $code ) ) {
      // TODO: Raise Exception
    }

    $this->_code = $code;
    $this->_description = $description;

  }

  public function getCode() {

    return $this->_code;

  }

  public function addBody( Body $body ) {

    $this->_bodies[ $body->getMediaType() ] = $body;
    return $this;

  }

  public function getBodies() {

    return $this->_bodies;

  }

  public function describeAs( $description ) {

    $this->_description = $description;
    return $this;

  }

  public function getDescription() {

    return $this->_description;

  }

}

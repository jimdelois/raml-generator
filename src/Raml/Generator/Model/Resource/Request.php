<?php

namespace DeLois\Raml\Generator\Model\Resource;

use DeLois\Raml\Generator\Model\AbstractNamedParameter;

class Request {

  private $_method;

  private $_description;

  private $_bodies = [];

  private $_headers = [];

  private $_responses = [];

  private $_parameters = [];


  public function __construct( $method, $description = null ) {

    if ( !\Improv\Http\Request\Method::isValid( $method ) ) {
      // TODO: Raise Exception
    }

    $this->_method      = $method;
    $this->_description = $description;

  }

  public function getMethod() {

    return $this->_method;

  }

  public function describeAs( $description ) {

    $this->_description = $description;
    return $this;

  }
  public function getDescription() {

    return $this->_description;

  }


  public function addBody( Body $body ) {

    $this->_bodies[ $body->getMediaType() ] = $body;
    return $this;

  }

  public function getBodies() {

    return $this->_bodies;

  }

  public function addHeader( NamedParameter $parameter ) {

    $this->_headers[ $parameter->getName() ] = $parameter;
    return $this;

  }

  public function setHeaders( array $parameters ) {

    $this->_headers = $parameters;
    return $this;

  }

  public function getHeaders() {

    return $this->_headers;

  }

  public function addResponse( Response $response ) {

    $this->_responses[ $response->getCode() ] = $response;
    return $this;

  }

  public function setResponses( array $responses ) {

    $this->_responses = $responses;
    return $this;

  }

  public function getResponses() {

    return $this->_responses;

  }

  public function addParameter( AbstractNamedParameter $parameter ) {

    $this->_parameters[ $parameter->getName() ] = $parameter;

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

}

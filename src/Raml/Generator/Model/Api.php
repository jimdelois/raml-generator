<?php

namespace DeLois\Raml\Generator\Model;

use DeLois\Raml\Generator\Model\Parameter\StringParameter;
use DeLois\Raml\Generator\Model\Uri\BaseUri;

class Api {

  const VERSION_0_8 = 0.8;

  const PROTOCOL_HTTP = 'HTTP';
  const PROTOCOL_HTTPS = 'HTTPS';

  const MEDIA_TYPE_JSON = 'text/json';

  /**
   * @var float
   */
  private $_raml_version;

  private $_api_version;

  private $_title;

  private $_base_uri;

  private $_protocols = [];

  private $_default_media;

  // TODO: Add these at some point.
  private $_schemas = [];

  private $_resources;


  public function __construct( $raml_version = self::VERSION_0_8 ) {

    $this->_raml_version = $raml_version;

  }


  public function setVersion( $v ) {
    $this->_api_version = $v;
    return $this;
  }


  public function setTitle( $title ) {
    $this->_title = $title;
    return $this;
  }


  public function getTitle() {
    return $this->_title;
  }


  public function getRamlVersion() {
    return $this->_raml_version;
  }


  public function setBaseUri( BaseUri $base_uri ) {

    $this->_base_uri = $base_uri;

    if ( $this->_api_version ) {

      $parameter = new StringParameter( 'version' );
      $parameter->defaultsTo( $this->_api_version );

      $this->_base_uri->addParameter( $parameter );

    }

    return $this;

  }


  public function getBaseUri() {

    return $this->_base_uri;

  }


  public function setDefaultMediaType( $media_type ) {

    $this->_default_media = $media_type;
    return $this;

  }


  public function getDefaultMediaType() {

    return $this->_default_media;

  }


  public function addProtocol( $protocol ) {

    $this->_protocols[] = $protocol;

    return $this;

  }


  public function getProtocols() {

    return $this->_protocols;

  }


  public function render( &$string ) {

    return $string;

  }


  public function addResource( Resource $resource ) {

    $this->_resources[ (string) $resource->getUri() ] = $resource;

  }


  public function getResources() {

    return $this->_resources;

  }

}

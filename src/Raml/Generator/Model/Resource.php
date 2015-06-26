<?php

namespace DeLois\Raml\Generator\Model;

use DeLois\Raml\Generator\Model\Resource\Request;
use DeLois\Raml\Generator\Model\Uri\UriSegment;

class Resource {

  private $_parent;
  private $_resources = []; // TODO: Make this a baller iterable object

  private $_requests = [];

  private $_uri;

  private $_display_name;

  private $_description;

  public function __construct( UriSegment $uri ) {

    $this->_uri = $uri;

  }

  public function getUri() {

    return $this->_uri;

  }

  public function describeAs( $description ) {

    $this->_description = $description;
    return $this;

  }

  public function getDescription() {
    return $this->_description;
  }

  public function displayAs( $display_name ) {

    $this->_display_name = $display_name;
    return $this;

  }


  public function isLeaf() {
    return count( $this->_resources ) === 0;
  }

  public function isTopLevel() {
    return $this->_parent === null;
  }

  public function isSubResource() {
    return !$this->isTopLevel();
  }

  public function setParent( Resource $resource ) {
    $this->_parent = $resource;
  }

  public function addResource( Resource $resource ) {
    // If it already exists here, complain
    $this->_resources[ (string) $resource->getUri() ] = $resource;
  }

  public function getResources() {
    return $this->_resources;
  }

  public function addRequest( Request $request ) {

    $this->_requests[ $request->getMethod() ] = $request;
    return $this;

  }

  public function getRequests() {

    return $this->_requests;

  }

}

<?php

namespace DeLois\Raml\Generator\Model\Parameter;

use DeLois\Raml\Generator\Model\AbstractNamedParameter;

class StringParameter extends AbstractNamedParameter {

  protected $_enum = [];

  protected $_pattern;

  protected $_length_min;

  protected $_length_max;

  public function __construct( $name, $description = null, $required = false ) {

    parent::__construct( self::TYPE_STRING, $name, $description, $required );

  }

  public function addEnumValue( $value ) {

    $this->_enum[] = $value;
    return $this;

  }

  public function setEnum( array $enum ) {

    $this->_enum = $enum;
    return $this;

  }

  public function getEnum() {

    return $this->_enum;

  }

  public function setPattern( $pattern ) {

    $this->_pattern = $pattern;
    return $this;

  }

  public function getPattern() {

    return $this->_pattern;

  }


  public function setLengthMin( $min ) {

    $this->_length_min = $min;
    return $this;

  }

  public function getLengthMin() {

    return $this->_length_min;

  }


  public function setLengthMax( $max ) {

    $this->_length_max = $max;
    return $this;

  }

  public function getLengthMax() {

    return $this->_length_max;

  }

}

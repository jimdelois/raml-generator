<?php

namespace DeLois\Raml\Generator\Model\Parameter;

class IntegerParameter extends AbstractNumericParameter {

  public function __construct( $name, $description = null, $required = false ) {

    parent::__construct( self::TYPE_INTEGER, $name, $description, $required );

  }

}
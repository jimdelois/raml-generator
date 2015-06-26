<?php

namespace DeLois\Raml\Generator\Model\Parameter;


class NumberParameter extends AbstractNumericParameter {

  public function __construct( $name, $description = null, $required = false ) {

    parent::__construct( self::TYPE_NUMBER, $name, $description, $required );

  }

}

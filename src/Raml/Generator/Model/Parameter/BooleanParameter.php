<?php

namespace DeLois\Raml\Generator\Model\Parameter;

use DeLois\Raml\Generator\Model\AbstractNamedParameter;

class BooleanParameter extends AbstractNamedParameter {

  public function __construct( $name, $description = null, $required = false ) {

    parent::__construct( self::TYPE_BOOLEAN, $name, $description, $required );

  }

}


<?php
namespace DeLois\Raml\Generator\Model\Parameter;

use DeLois\Raml\Generator\Model\AbstractNamedParameter;

abstract class AbstractNumericParameter extends AbstractNamedParameter {

  protected $_minimum;
  protected $_maximum;

  public function getMinimum() {

    return $this->_minimum;

  }

  public function getMaximum() {

    return $this->_maximum;

  }

}

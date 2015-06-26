<?php

namespace DeLois\Raml\Generator\Model;


abstract class AbstractNamedParameter {

  protected $_name;

  protected $_display_name;

  protected $_description;

  protected $_type;

  protected $_example;

  protected $_repeat = false;

  protected $_required = false;

  protected $_default;

  const TYPE_STRING = 'string';
  const TYPE_NUMBER = 'float';
  const TYPE_INTEGER = 'integer';
  const TYPE_DATE = 'date'; // Must be UTC
  const TYPE_BOOLEAN = 'boolean';
  const TYPE_FILE = 'file';

  public function __construct( $type, $name, /*SomeClass*/ $description = null, $required = false ) {

    $this->_name        = $name;
    $this->_type        = $type;
    $this->_description = $description;
    $this->_required    = $required;

  }

  public function getName() {

    return $this->_name;

  }

  public function getType() {

    return $this->_type;

  }

  public function displayAs( $display ) {

    $this->_display_name = $display;
    return $this;

  }

  public function getDisplayName() {

    return $this->_display_name;

  }

  public function describeAs( $description ) {

    $this->_description = $description;
    return $this;

  }

  public function getDescription() {

    return $this->_description;

  }

  public function addExample( $example ) {

    $this->_example = $example;
    return $this;

  }

  public function getExample() {

    return $this->_example;

  }

  public function repeats( $bool = null ) {

    if ( $bool !== null ) {
      $this->_repeat = $bool;
      return $this;
    }

    return $this->_repeat;

  }

  public function required( $bool = null ) {

    if ( $bool !== null ) {
      $this->_required = $bool;
      return $this;
    }

    return $this->_required;

  }

  public function defaultsTo( $default ) {

    $this->_default = $default;
    return $this;

  }

  public function getDefault() {

    return $this->_default;

  }


  public static function isValidType( $type ) {

    static $cache_map = null;

    if ( $cache_map === null ) {

      $class     = new \ReflectionClass( get_called_class() );
      $constants = new \ArrayIterator( $class->getConstants() );
      $filtered  = new \CallbackFilterIterator( $constants, function ( $value, $key ) {
        return strpos( $key, 'TYPE_' ) === 0;
      } );

      foreach ( $filtered as $value ) {
        $cache_map[] = $value;
      }

    }

    return in_array( $type, $cache_map );

  }

  public function isType( $type ) {

    return $this->getType() === $type;

  }

}


<?php

namespace DeLois\Raml\Test;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase {

  protected function _getFullMock( $class_name ) {

    return $this->getMockBuilder( $class_name )
      ->disableOriginalConstructor()
      ->getMock();
  }

}

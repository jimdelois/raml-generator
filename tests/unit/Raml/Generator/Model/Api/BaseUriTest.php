<?php

namespace DeLois\Raml\Generator\Model\Uri;

use DeLois\Raml\Generator\Model\Api;
use DeLois\Raml\Generator\Model\Parameter\StringParameter;
use DeLois\Raml\Generator\Model\Resource;
use DeLois\Raml\Test\AbstractTestCase;
use Improv\Http\Request\Method;

/**
 * @covers \DeLois\Raml\Generator\Model\Uri\BaseUri<extended>
 */
class BaseUriTest extends AbstractTestCase {

  const CLASS_NAMED_PARAMETER = '\DeLois\Raml\Generator\Model\AbstractNamedParameter';

  /**
   * @test
   */
  public function toString() {

    $url = 'https://example.com';
    $sut = new BaseUri( $url );

    $this->assertEquals( $url, $sut->__toString() );

  }


  /**
   * @test
   * @dataProvider validParameterProvider
   *
   * @param string $url
   * @param array  $parameter_keys
   */
  public function addValidParameters( $url, array $parameter_keys ) {

    $sut = new BaseUri( $url );

    $parameters = [];

    foreach ( $parameter_keys as $parameter_key ) {

      $mock = $this->_getFullMock( self::CLASS_NAMED_PARAMETER );
      $mock->expects( $this->once() )
        ->method( 'getName' )
        ->will( $this->returnValue( $parameter_key ) );

      $parameters[ $parameter_key ] = $mock;

    }

    $sut->addParameters( $parameters );

    $this->assertEquals( $parameters, $sut->getParameters() );

  }


  /**
   * @test
   * @dataProvider invalidParameterProvider
   *
   * @param string $url
   * @param string $parameter_key
   */
  public function addInvalidParameter( $url, $parameter_key ) {

    $sut = new BaseUri( $url );

    $mock = $this->_getFullMock( self::CLASS_NAMED_PARAMETER );
    $mock->expects( $this->once() )
      ->method( 'getName' )
      ->will( $this->returnValue( $parameter_key ) );

    $this->setExpectedException( '\InvalidArgumentException' );
    $sut->addParameter( $mock );

  }

  /**
   * @return array
   */
  public function validParameterProvider() {

    return [
      [ 'https://{something}.example.com', [
        'something',
      ] ],
      [ 'https://{something}.{else}.example.com', [
        'something',
      ] ]
    ];
  }

  /**
   * @return array
   */
  public function invalidParameterProvider() {

    return [
      [ 'https://something.example.com', 'something' ],
    ];
  }

}

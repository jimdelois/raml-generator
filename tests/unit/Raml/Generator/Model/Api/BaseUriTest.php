<?php

namespace DeLois\Raml\Generator\Model\Uri;

use DeLois\Raml\Generator\Model\Api;
use DeLois\Raml\Generator\Model\Parameter\IntegerParameter;
use DeLois\Raml\Generator\Model\Parameter\StringParameter;
use DeLois\Raml\Generator\Model\Resource;
use DeLois\Raml\Test\AbstractTestCase;
use Improv\Http\Request\Method;
use Improv\Http\Response\Code;

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


  /**
   * @test
   */
  public function assembly() {

    $api = ( new Api() )
      ->setTitle( 'My App Plugin API for View Clients' )
      ->setVersion( 'v1' )
      ->setBaseUri( new BaseUri( 'https://my-app.com/{version}/app' ) )
      ->addProtocol( Api::PROTOCOL_HTTPS )
      ->setDefaultMediaType( Api::MEDIA_TYPE_JSON );

    $resource_users = ( new Resource( new UriSegment( '/users' ) ) )
      ->displayAs( 'User Profiles' )
      ->describeAs( 'This endpoint provides the ability to search for plugin profiles by Profile User ID.' );

    $request_get = ( new Resource\Request( Method::GET ) )
      ->describeAs( 'Get User Profile(s)' );

    $param_adobe_id = new StringParameter( 'profile_id', 'The Profile ID of the user whose profile is desired', true );
    $param_adobe_id->addExample( '14A2477F5398CF300A4C8375@ProfileID' );

    $request_get->addParameter( $param_adobe_id );





    $response_body = new Resource\Body( Resource\Body::MEDIA_TYPE_JSON );

    $response_body->addExample( <<<EOX

{
  "users": {
    "14A2477F5398CF300A4C8375@ProfileID": {
      "profile_id": "14A2477F5398CF300A4C8375@ProfileID",
      "first_name": "Jim",
      "last_name": "DeLois"
    }
  }
}
EOX
    );

    $response = ( new Resource\Response( Code::OK ) )
      ->addBody( $response_body );


    $request_get->addResponse( $response );

    $resource_users->addRequest( $request_get );

    $api->addResource( $resource_users );











    $uri_segment = new UriSegment( '/users/{user_id}/projects' );
    $uri_segment->addParameter( new IntegerParameter( 'user_id', 'The Application User ID of the user whose projects are desired', true ) );

    $resource = ( new Resource( $uri_segment ) )
      ->displayAs( 'User Projects' )
      ->describeAs( 'A suite of endpoints centered on a specific user\'s projects');

    $request_get = ( new Resource\Request( Method::GET ) )
      ->describeAs( 'List All User Projects' );

    $response_get_body = ( new Resource\Body( Resource\Body::MEDIA_TYPE_JSON ) )
      ->addExample( <<<EOX

{
  "projects": {
    "1": { ... },
    "2": { ... }
  }
}
EOX
    );

    $response_get = ( new Resource\Response( Code::OK ) )
      ->addBody( $response_get_body );

    $request_get->addResponse( $response_get );






    $request_post = ( new Resource\Request( Method::POST ) )
      ->describeAs( 'Validate and Persist a Plugin Project' );

    $request_post_body = ( new Resource\Body( Resource\Body::MEDIA_TYPE_FORM ) )
      ->addParameter(
        ( new IntegerParameter( 'plugin_project_id', 'The ID of the Plugin Project to validate and sync to The Application', true ) )
          ->addExample( 'plugin_project_id=524' )
      );

    $request_post->addBody( $request_post_body );


    $response_post_created = ( new Resource\Response( Code::CREATED ) )
      ->addBody(
        ( new Resource\Body( Resource\Body::MEDIA_TYPE_JSON ) )
          ->addExample( <<<EOX

{
  "project": {
    ...
  }
}
EOX
          )
      )->describeAs( 'A Project\'s details will be return on success' );


    $response_post_invalid = ( new Resource\Response( Code::BAD_REQUEST ) )
      ->addBody(
        ( new Resource\Body( Resource\Body::MEDIA_TYPE_JSON ) )
          ->addExample( <<<EOX

{
  "http_code": 400,
  "messages": [
    {
      "type": "error",
      "message": "Invalid Plugin Project"
    }
  ]
}
EOX
          )
      )->describeAs( 'If the Project does not belong to the user or does not exist in the Plugin' );


    $request_post->addResponse( $response_post_created );

    $request_post->addResponse( $response_post_invalid );

    $resource->addRequest( $request_get );
    $resource->addRequest( $request_post );

    $api->addResource( $resource );


    print_r( $api );


    $this->assertTrue( true );
  }

}

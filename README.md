# raml-generator
An object-oriented, PHP library intended to generate RAML. Useful for authoring custom parsers.

## Working example (of functionality so far)

```php

    use DeLois\Raml\Generator\Model\Api;
    use DeLois\Raml\Generator\Model\Parameter\StringParameter;
    use DeLois\Raml\Generator\Model\Resource;
    use DeLois\Raml\Generator\Model\Resource\Request;
    use Improv\Http\Request\Method;

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
      

    // Obviously still need to add the rendering/output...

```

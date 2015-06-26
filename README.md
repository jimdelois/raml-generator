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
    ->setTitle( 'The Best API Known to Man' )
    ->setVersion( 'v1' )
    ->setBaseUri( new BaseUri( 'https://example.com/{version}' ) )
    ->addProtocol( Api::PROTOCOL_HTTPS )
    ->setDefaultMediaType( Api::MEDIA_TYPE_JSON );
  
  $resource_members = ( new Resource( new UriSegment( '/members' ) ) )
    ->displayAs( 'Member Profiles' )
    ->describeAs( 'This endpoint provides the ability to search for member profiles by ID' );

  $api->addResource( $resource_users );


  $request_get = ( new Request( Method::GET ) )
    ->describeAs( 'Get Member Profile(s)' )
    ->addParameter( new StringParameter( 'profile_id', 'The Profile ID of the user whose profile is desired', true ) )
    ;

  $resource_members->addRequest( $request_get );
  
  //$request_get->addResponse();
  // etc

  // Obviously still need to add the rendering/output...

```

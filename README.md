


This extension was built by distriqt // 

# Parse 

Access to the Parse SDK in your application.


Features

- Setup the Parse SDK to receive push notifications
- Single API interface: Works across iOS and Android with the same code
- Sample project code and ASDocs reference


## Documentation

Latest documentation:

http://airnativeextensions.com/extension/com.distriqt.Parse

```actionscript
Parse.service.addEventListener( ParseEvent.NOTIFICATION, parse_notificationHandler );

//
// Setup and register this application for notifications
Parse.service.setupApplication( _parseAppId, _parseClientKey );

...


private function parse_notificationHandler( event:ParseEvent ):void
{
	trace("Remote notification received! :: " + event.type );
	trace( event.data );	
}

```


## License

You can purchase a license for using this extension:

http://airnativeextensions.com

distriqt retains all copyright.



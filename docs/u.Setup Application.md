
## Setup the application and Notification registration

Now we need to provide the `APPLICATION ID` and `CLIENT KEY` you should have noted eariler. 
During the `setupApplication` call the application will be initialised and registered for notifications.

If any notifications were received on startup then they will be dispatched at this 
point so it is important that you add any required listeners for the notification 
events before calling setup, otherwise you may miss the startup notification.

When registration has succeeded you can subscribe to any specific channels you may 
require for your user. You can also list any subscriptions the user currently has. 
See the asdocs for more on these calls.


```as3
if (Parse.isSupported)
{
	Parse.service.addEventListener( ParseEvent.NOTIFICATION, parse_notificationHandler );
	Parse.service.addEventListener( ParseEvent.REGISTER_SUCCESS, parse_registerHandler );
	Parse.service.addEventListener( ParseEvent.ERROR, parse_errorHandler );
	
	// 
	// The important setup call with your APPLICATION ID and CLIENT KEY from Parse
	Parse.service.setupApplication( "PARSE_APPLICATION_ID", "PARSE_CLIENT_KEY" );
}
```

```as3
private function parse_registerHandler( event:ParseEvent ):void
{
	// Your application is now setup and registered for push notifications
}

private function parse_errorHandler( event:ParseEvent ):void
{
	trace( "ERROR:: " + event.data );
}

private function parse_notificationHandler( event:ParseEvent ):void
{
	trace("Remote notification received! :: " + event.type );
	trace( event.data );
}
```

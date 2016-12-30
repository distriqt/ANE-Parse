
## Add the Extension

First step is always to add the extension to your development environment. 
To do this use the tutorial located [here](https://airnativeextensions.com/knowledgebase/tutorial/1).


## Required ANEs

### Core ANE

The Core ANE is required by this ANE. You must include this extension in your application and call 
the initialisation function at some point, generally at the same time as the initialisation of this 
extension. If you are using other extensions that also require the Core ANE, you only need to 
initialise it once, generally before initialising the other extensions.

```as3
Core.init();
```

The Core ANE doesn't provide any functionality in itself but provides support libraries and frameworks used by our extensions.
It also includes some centralised code for some common actions that can cause issues if they are implemented in each individual extension.

You can access this extension here: [https://github.com/distriqt/ANE-Core](https://github.com/distriqt/ANE-Core).


### Bolts ANE

Due to a couple of our ANE's (mainly Facebook and Parse) using the Bolts library the library 
has been separated into a separate ANE allowing you to avoid conflicts and duplicate definitions.

This means that you need to include the `com.distriqt.Bolts` native extension in your application 
along with this extension. 

You can access this extension here: [https://github.com/distriqt/ANE-Bolts](https://github.com/distriqt/ANE-Bolts).

You'll add this extension as you do with any other ANE, you just need to ensure it's packaged with your application.



## Android Manifest Additions

There is nothing specific required to setup your application for Push on Android. All of the configuration 
instead goes into the manifest additions which we will go through below. If you are having issues with push 
notifications on Android then most likely it's caused by an error in the manifest so take care and add them 
all as below making sure to replace your application package name where appropriate.

The following additions must be added to your applications manifest additions.


```xml
<manifest android:installLocation="auto">

	<uses-permission android:name="android.permission.INTERNET"/>
	<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
	<uses-permission android:name="android.permission.WAKE_LOCK" />
	<uses-permission android:name="android.permission.VIBRATE" />
	<uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED" />
	<uses-permission android:name="android.permission.GET_ACCOUNTS" />
	<uses-permission android:name="com.google.android.c2dm.permission.RECEIVE" />
	
	<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE"/>
   
	<!--
	IMPORTANT: Change "YOUR_APP_ID" to match your app's package name.
	-->
	<permission android:name="YOUR_APP_ID.permission.C2D_MESSAGE" android:protectionLevel="signature" />
	<uses-permission android:name="YOUR_APP_ID.permission.C2D_MESSAGE" />
	
	
	<application android:name="com.distriqt.extension.parse.ParseApplication">
    
		<service android:name="com.parse.PushService" />
		
		<receiver android:name="com.parse.ParseBroadcastReceiver">
			<intent-filter>
				<action android:name="android.intent.action.BOOT_COMPLETED" />
				<action android:name="android.intent.action.USER_PRESENT" />
			</intent-filter>
		</receiver>
		
		<receiver android:name="com.parse.GcmBroadcastReceiver" android:permission="com.google.android.c2dm.permission.SEND">
			<intent-filter>
				<action android:name="com.google.android.c2dm.intent.RECEIVE" />
				<action android:name="com.google.android.c2dm.intent.REGISTRATION" />
				
				<!--
				IMPORTANT: Change "YOUR_APP_ID" to match your application package name.
				-->
				<category android:name="YOUR_APP_ID" />
			</intent-filter>
		</receiver>			
		
		<receiver android:name="com.distriqt.extension.parse.ParseNotificationsReceiver" android:exported="false">
			<intent-filter>
				<action android:name="com.parse.push.intent.RECEIVE" />
				<action android:name="com.parse.push.intent.DELETE" />
				<action android:name="com.parse.push.intent.OPEN" />
			</intent-filter>
		</receiver>
		
	</application>
    
</manifest>
```


## iOS Info Additions

You need to add certain Entitlements to your application to be able to use Push Notifications.

```xml
<iPhone>
	<InfoAdditions><![CDATA[
		<key>UIDeviceFamily</key>
		<array>
		<string>1</string>
		</array>
		)>
	</InfoAdditions>
	<requestedDisplayResolution>high</requestedDisplayResolution>
	<Entitlements><![CDATA[
		<key>get-task-allow</key>
		<true/>
		<key>aps-environment</key>
		<string>development</string>
		<key>application-identifier</key>
		<string>X5LW23Q6CJ.com.distriqt.test</string>
		<key>keychain-access-groups</key>
		<array>
			<string>X5LW23Q6CJ.*</string>
		</array>
	)></Entitlements>
</iPhone>
```

These all relate to your application’s entry in the iOS Provisioning Portal.

The first field is the aps-environment. This field indicates whether we are using the development or 
the production environment. It must be either development or production and depends on which 
configuration you are using. If you are running a debug build you should use development. 
If you are looking to publish the application to the AppStore, you should use production.

If you took note of the applications Bundle Seed ID (App ID Prefix) and Bundle Identifier 
(App ID Suffix) previously then you can use them here, otherwise see the next section on 
how to “Acquire the App ID Prefix and Suffix” and return here with that information.



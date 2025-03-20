# webcaste
webcastle google auth and trillo

1. downloaded the codeigniter
2. install Google Outh - composer require google/apiclient
3. configure the Google Outh
	- go to console.cloud.google.com
		-> create a new project.
		-> go to APIs & Services → Credentials.
		-> go to Create Credentials → OAuth client ID 
		-> fill the details like (Application type, select Web application)
		-> add Authorized redirect URIs
		-> click create
		these details are added in config.php
	- go to APIs & Services → Library
		-> find Google Calendar API and Enable it
3. install twillo - composer require twilio/sdk
4. configure the twillo
	- go to console.twilio.com
		-> create a new login.
		-> get a number update details and get the etails link id 
		these details are added in config.php
5. to the login page : localhost/webcastle
6. login to the user which is added in google outh
7. it will list the events of that mails.
8. to get the reminder sms using this url localhost/webcastle/Dashboard/cron 

update the config file with the parameter

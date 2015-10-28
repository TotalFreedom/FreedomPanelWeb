#FreedomPanel Web

##Basic Information
A web panel for Freedom Servers built for [TotalFreedomMod](https://github.com/TotalFreedom/TotalFreedomMod) and [FreedomPanel](https://github.com/TotalFreedom/FreedomPanel). Built for the [TotalFreedomMC](http://totalfreedom.me) server.


######Incomplete, features may or may not work

###Features

* User accounts
* Permission levels
* Integrated logviewer
* Web based map changes
* Web based console
* Integration with TotalFreedomMod and the FreedomPanel backend

###Pre-Requisites
- PHP 5.4 or newer with OpenSSL
- HTTP(S) Web Server (Apache or nginx have both been tested)
- MySQL database

###Usage
- Extract the panel onto a PHP 5.4+ web server -
- Import the .sql file into a MySQL database
- Enter database details into `global/config.php`
- Login to the panel with the username _admin_ password _admin_ - please change this account password as soon as possible.
- Create a user account for yourself, and then set up from the admin panel.


###API Usage
FreedomPanelWeb includes an API that can be accessed by users, this allows third party applications to be developed that can
communicate with the server via the FreedomPanel using a particular user's user account.

- A users API key can be found on the user's account page, it can also be regenerated from here.
- Any API access is performed at the same permission level as the user.
- All usage under an API key, will be logged as the user in which the key belongs to.
- The API can be globally disabled from the config.

Anyone can develop applications that will use the API. The API is a simple HTTP API with JSON responses.

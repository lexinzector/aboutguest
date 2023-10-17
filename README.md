# AboutGuest
User information in PHP - IP, browser, operating system, robot

## Provides
- browser name
- browser version
- operating system name
- operating system version/kernel
- visitor IP
- check: whether the user has logged in from a browser
- check: whether the user is logged in from a mobile device
- name of brand/OS/browser of mobile phone, smartphone, tablet
- check: whether the visitor is a search engine robot
- which search engine does the robot belong to

## How the PHP class works to determine visitor data by user-agent
From the arrays folder, associative arrays are loaded that contain abbreviations or short names of browsers, operating systems or robots that appear in the user-agent line that we receive from the browser.
After receiving the data, all methods that have the set_ prefix are dynamically called and fill the class variables, because only they are public and can be taken out of the scope of the class.

## Requirements
PHP >= 5.6.0

## Installation
run in console:
```
composer require lexinzector/aboutguest
```

## Methods
```php
$this->load($file_and_array_name)
```
Loader. This method loads arrays from the arrays folder and assigns them to the variable specified in the value of the $file_and_array_name attribute, this attribute is also the name of the file from the arrays folder.

```php
$this->set_ip()
```
Returns a value from the $_SERVER array with the REMOTE_ADDR key, as you know $_SERVER['REMOTE_ADDR'] is the user's IP that is accessible to the browser.

```php
$this->set_browser()
```
array file: arrays / browsers.php
After the $this->load method has loaded the arrays, this method will work with the array from the $this->browsers object. Once it finds a match between the array key and the contents of the string in $this->agent, it assigns the $this->browser object the value of the key in the $this->browsers array. Also, this method also assigns the browser version in $this->version. Since the browser has already found a match, there is no doubt that the user came from the browser and did not access the site through a script. Set $this->is_browser to True;

```php
$this->set_operating_system()
```
array file: arrays / operating_systems.php
It works in the same way as the $this->set_browser method, except that it uses the $this->operating_systems object as an array to check for a match, which received the array from the arrays/operating_systems.php file after executing the $this->load() method. Unfortunately, browsers are not so active in dealing with the version of the operating system and sometimes you can get strange numbers instead of the version. So be careful when you use $this->os_version. The name of the operating system is contained in $this->operating_system (not to be confused with $this->os_version)

```php
$this->set_robot()
```
array file: arrays / robots.php
We check if the site visitor is not a search engine robot. If he is a robot then the value for $this->is_robot will be TRUE; the value $this->robot will contain the name of the search engine that launched the robot on the site (Google Bot, Yandex Bot, Rambler Bot...)

```php
$this->set_mobile()
```
array file: arrays / mobiles.php
It works similarly to the $this->set_operating_system() method, only it assigns the name of the phone brand to the $this->mobile object and the value of $this->is_mobile will be TRUE if logged in from a mobile phone, smartphone or tablet.

## Example
```php
use \Lexinzector\AboutGuest\AboutGuest;

// useragent autodetection
$AboutGuest = new AboutGuest;
// custom useragent
$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36';
$AboutGuest = new AboutGuest($useragent);

echo 'User Agent: ' . $AboutGuest->agent . '<br />';
echo 'IP: ' . $AboutGuest->ip . '<br />';
echo 'Browser: ' . $AboutGuest->browser . '<br />';
echo 'Browser version: ' . $AboutGuest->version . '<br />';
echo 'Operating System: ' . $AboutGuest->operating_system . '<br />';
echo 'OS version: ' . $AboutGuest->os_version . '<br />';
echo 'I am a robot? ' . $AboutGuest->is_robot . '<br />';
echo 'Robot belongs: ' . $AboutGuest->robot . '<br />';
echo 'Logged in from a mobile phone? ' . $AboutGuest->is_mobile . '<br />';
echo 'Mobile phone: ' . $AboutGuest->mobile . '<br />';
```

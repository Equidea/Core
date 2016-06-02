# Core
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Equidea/Core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Equidea/Core/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Equidea/Core/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Equidea/Core/build-status/master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Equidea routing system and http abstraction layer

#### Routing basics
<img src="http://www.bilder-upload.eu/upload/72bd54-1464908254.png">

##### Creating a request
```php
$request = Request::createFromGlobals();
```

###### Starting the game app
```php
Equidea::register($request);
```

###### Adding static pages to the game app
```php
Equidea::get('/', ['IndexController', 'showIndex']);
Equidea::get('/impressum', ['PagesController', 'showImpressum']);
```

##### Run the app and send the response
```php
Equidea::respond();
```

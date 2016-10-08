# Equidea Core
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Equidea/Core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Equidea/Core/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Equidea/Core/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Equidea/Core/build-status/master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

The small and simple framework used in Equidea featuring
* A small Autoloader
* Configuration
* An HTTP abstraction layer
* HTTP controller routing
* A Database access layer
* A small Service container
* A Templating system

# Usage
The Equidea Core can be used as any other open source MVC framework, but it sports the - subjectively perceived - advantage of being less complex whilst still being efficient for its predetermined usage. This means that the Core consists of only the features that will be actually used in the game.

## Autoloading
Equidea implements the PSR-4 autoloading standard.

```php
<?php

use Equidea\Autoloader;

require __DIR__.'/src/Autoloader.php';

// Start the Autoloader
$autoload = new Autoloader();

// Add a PSR-4 namespace prefix. 
// The first argument of the function must be the namespace and the second its associated path.
$autoload->addNamespace('Equidea', __DIR__.'/src/');

// Register the autoloader
$autoload->register();
```

## HTTP Requests and their composition
Equidea Core features a small implementation of an HTTP abstraction layer that is similar to the PSR-7 standard but does not actually implement it. Instead Equidea uses its own slightly less complex interfaces.

HTTP request data will be saved into the **Equidea\Http\Request** object that implements the **Equidea\Http\Interfaces\RequestInterface**.
This object is composed of the **Equidea\Http\Uri** object that implements the **Equidea\Http\Interfaces\UriInterface**, the **Equidea\Http\Input** object, that implements the **Equidea\Http\Interfaces\InputInterface** and the **Equidea\Http\Session** object that implements the **Equidea\Http\Interfaces\SessionInterface**.

```php
<?php

use Equidea\Http\{Input, Request, Session, Uri};

// Create an instance of Input.
$input = new Input($_GET, $_POST);

// Create an instance of Session
$session = new Session();

// Create an instance of Uri
$uri = new Uri($_SERVER['REQUEST_URI']);

// Get the request method
$method = $_SERVER['REQUEST_METHOD']

// Create an instance of Request
$request = new Request($method, $uri, $input, $session);
```

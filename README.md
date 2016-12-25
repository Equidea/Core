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
The Equidea Core can be used like any other open source MVC framework, but it sports the - subjectively perceived - advantage of being less complex whilst still being efficient for its predetermined usage. This means that the Core consists of only the features that will be actually used in the game.

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
$method = $_SERVER['REQUEST_METHOD'];

// Create an instance of Request
$request = new Request($method, $uri, $input, $session);
```

The general system enables you to completely fake an HTTP request, e.g. when you need it for testing purposes. But since the Session object is a bit special, you need to use the **\Equidea\Http\Mockups\SessionMockup** object that also implements the **Equidea\Http\Interfaces\SessionInterface** for testing.

```php
<?php

use Equidea\Http\{Input, Request, Uri};
use Equidea\Http\Mockups\SessionMockup;

// Create an instance of Input.
$input = new Input(['id' => 2], ['username' => 'Phieleia']);

// Create an instance of SessionMockup
$session = new SessionMockup(['authenticated' => true]);

// Create an instance of Uri
$uri = new Uri('/user/2');

// Get the request method
$method = 'POST';

// Create an instance of Request
$request = new Request($method, $uri, $input, $session);
```

If you want to get a Request object with the Request data originating from the globals, such as **$\_SERVER** and **$\_GET**, and don't want to create it the long way round, you can optionally just use the static shortcut method **createFromGobals()**

```php
$request = Request::createFromGlobals();
```

To fetch the **HTTP GET**, **HTTP POST** or **SESSION** data you can retrieve it by using the methods **get()**, **post()** and **session()**.

```php
// Retrieves the entire GET/POST data as an associative array
$request->get();
$request->post();
$request->session();

// Retrieves the data for a specific key
$request->get('id');
$request->post('username');
$request->session('authenticated');

// Retrieves the data for a specific key, but if the field is empty, it returns a default value
$request->get('id', 1);
$request->post('username', 'Equidea');
$request->session('authenticated', false);
```

To retrieve the **HTTP Request Method** and the **URI** you can use **getMethod()** and **uri()**.

```php
// Returns the HTTP verb for the request, e.g. POST
$method = $request->getMethod();
// Returns the URI as a string, e.g. /user/1
$uri = $request->uri();
```

## The Database Object

To simplify interactions with the MySQL database, the Equidea Core includes the **\Equidea\Database\Database** class.

```php
<?php

use Equidea\Database\Database;

// Define the database configuration
$config = [
    // The name of the database host
    'host' => 'localhost',
    // The name of the database user
    'user' => 'root',
    // The password, if set, otherwise left empty
    'password' => '',
    // The name of the database
    'name' => 'equidea',
    // The default character set
    'char' => 'utf8'
];

// Create a new instance of database.
$database = new Database($config);
```

With the Database class you can run raw SQL queries using the methods **select()**, **insert()**, **update()** and **delete()**.

```php
// Simple select
$database-select('SELECT * FROM `users`');

// Select with prepared statements
$database->select(
    'SELECT * FROM `users` WHERE `id` = :id AND `username` = :username',
    ['id' => 1, 'username' => 'Mina']
);

// Update
$database->update(
    'UPDATE `users` SET `email` = :email WHERE `id` = :id',
    ['email' => 'info@equidea-game.com','id' => 1]
);
```

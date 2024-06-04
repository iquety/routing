# Configuring routes

--page-nav--

## 1. Mapping routes

Through the router, you must specify the routes that should be analyzed to
identify user requests. The available verbs are:

```php
$router->any('...');
$router->get('...');
$router->post('...');
$router->put('...');
$router->patch('...');
$router->delete('...');
```

> Note: The `any` method is special and represents any verb coming from the user
request.

The `any`, `get`, `post`, `put`, `patch` and `delete` methods, which define the
routes, are fluent and return a `Route` object, which is used to pass configurations
the route.

## 2. Defining the action routine

The routine to be executed, when the route matches the user's request, is
defined with the `usingAction` method:

```php
$router = new Router();

$router->get('/user/edit/:id')
       ->usingAction(UserController::class, 'edit');
```

In the example above, the `edit` method of the `UserController` class is mapped
to the URI `/user/edit/<some-number>` when the HTTP verb used is `GET`.

It is also possible to define a routine directly through an anonymous function:

```php
$router = new Router();

$router->get('/user/edit/:id')->usingAction(function() {
    return 'olá';
});
```

In the example above, the callback will be mapped to the URI `/user/edit/<some-number>`
when the HTTP verb used is `GET`.

## 3. Setting module identification

When implementing a system with modules, it may be interesting to know which
module the route originated from. To do this, when declaring the route, you can
define this information:

```php
$router = new Router();

$router->any('...')
    ->forModule('identificação do meu módulo');
```

--page-nav--

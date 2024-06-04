# How to use the router

[◂ Documentation index](index.md) | [Configuring routes ▸](02-route.md)
-- | --

## 1. Route not found

In the following example, the user's request for `product/create` does not match
no route defined. Then the `routeNotFound` method will contain the value `true`
and the `currentRoute` method will contain the value `null`.

```php
$router = new Router();

// maps the URI '/user/edit/<some-number>' to the GET verb
$router->get('/user/edit/:id');

// tries to find '/product/create' in the mapped routes
$router->process('GET', '/product/create');

if ($router->routeNotFound() === true) {
    echo 'This feature does not exist';
}
```

## 2. Route found

In the following example, the user requested that the router process the URI
`/user/edit/33` with the HTTP verb `GET`. In the process, the router will
identify that the URI matches the pattern `/user/edit/:id` and will determine the
current route, which can be obtained using the `currentRoute` method.

```php
$router = new Router();

// maps the pattern '/user/edit/:id' to the GET verb
$router->get('/user/edit/:id');

// checks the GET routes and tries to find
// '/user/edit/<some-number>' in defaults
$router->process('GET', '/user/edit/33');

// gets the route found to use its information
$currentRoute = $router->currentRoute();
```

## 3. Found route information

The route found, obtained by the `currentRoute` method, provides information
important for deciding how to respond to the user request.

```php
$router = new Router();

$route = $router->currentRoute();

// full name of the action class or anonymous function
$actionClass = $route->action();

// action class method name
$actionMethod = $route->actionMethod();

// verb referring to the route (GET,POST,PUT,PATCH,DELETE)
$httpMethod = $route->requestMethod();

// module identification
$moduleId = $route->module();

// parameters existing in the route
$paramList = $route->params();

// pattern defined in the route ('/user/edit/:id')
$pattern = $route->pattern();
```

[◂ Documentation index](index.md) | [Configuring routes ▸](02-route.md)
-- | --

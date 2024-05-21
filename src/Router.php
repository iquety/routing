<?php

declare(strict_types=1);

namespace Iquety\Routing;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class Router
{
    private ?Route $currentRoute = null;

    /** @var array<int,Route> */
    private array $routes = [];

    private bool $notFound = false;

    private string $moduleIdentifier = 'all';

    public function any(string $pattern): Route
    {
        return $this->addRoute(Route::ANY, $pattern);
    }

    public function delete(string $pattern): Route
    {
        return $this->addRoute(Route::DELETE, $pattern);
    }

    public function get(string $pattern): Route
    {
        return $this->addRoute(Route::GET, $pattern);
    }

    public function patch(string $pattern): Route
    {
        return $this->addRoute(Route::PATCH, $pattern);
    }

    public function post(string $pattern): Route
    {
        return $this->addRoute(Route::POST, $pattern);
    }

    public function put(string $pattern): Route
    {
        return $this->addRoute(Route::PUT, $pattern);
    }

    /** Obtém a rota atual */
    public function currentRoute(): ?Route
    {
        return $this->currentRoute;
    }

    /** Determina o módulo para o qual as rotas irão pertencer */
    public function forModule(string $moduleIdentifier): Router
    {
        $this->moduleIdentifier = $moduleIdentifier;

        return $this;
    }

    /** Busca a rota apropriada à requisição fornecida */
    public function process(string $method, string $path): void
    {
        $this->notFound = true;

        foreach ($this->routes as $routeObject) {
            if ($routeObject->matchTo($method, $path) === false) {
                continue;
            }

            $this->currentRoute = $routeObject;

            $this->notFound = false;

            break;
        }
    }

    public function resetModuleInfo(): Router
    {
        $this->moduleIdentifier = 'all';

        return $this;
    }

    public function routeNotFound(): bool
    {
        return $this->notFound;
    }

    /** @return array<int,Route> */
    public function routes(): array
    {
        return $this->routes;
    }

    private function addRoute(string $method, string $pattern): Route
    {
        $route = $this->makeRoute($method, $pattern);

        $routeId = count($this->routes);

        $this->routes[$routeId] = $route;

        return $this->routes[$routeId];
    }

    private function makeRoute(string $method, string $pattern): Route
    {
        $route = new Route();
        $route->forModule($this->moduleIdentifier);
        $route->usingPattern($pattern);
        $route->usingMethod($method);

        return $route;
    }
}

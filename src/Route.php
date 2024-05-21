<?php

declare(strict_types=1);

namespace Iquety\Routing;

use Closure;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class Route
{
    public const ANY    = 'ANY';
    public const DELETE = 'DELETE';
    public const GET    = 'GET';
    public const PATCH  = 'PATCH';
    public const POST   = 'POST';
    public const PUT    = 'PUT';

    private Closure|string $actionClass = '';

    private string $actionMethod = '';

    private string $requestMethod = 'GET';

    private string $module = '';

    /** @var array<int,string> */
    private array $nodes = [];

    /** @var array<string,int|string> */
    private array $params = [];

    private string $pattern = '/';

    public function forModule(string $moduleIdentifier): Route
    {
        $this->module = $moduleIdentifier;
        return $this;
    }

    public function usingAction(Closure|string $className, string $method = 'execute'): Route
    {
        $this->actionClass = $className;

        $this->actionMethod = $method;

        return $this;
    }

    public function usingRequestMethod(string $method): Route
    {
        $this->requestMethod = mb_strtoupper($method);

        return $this;
    }

    public function usingPattern(string $pattern): Route
    {
        $this->pattern = trim($pattern, "/");

        return $this;
    }

    public function action(): Closure|string
    {
        return $this->actionClass;
    }

    public function actionMethod(): Closure|string
    {
        return $this->actionMethod;
    }

    public function requestMethod(): string
    {
        return $this->requestMethod;
    }

    public function module(): string
    {
        return $this->module;
    }

    /** @return array<string,int|string> */
    public function params(): array
    {
        return $this->params;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    public function matchTo(string $method, string $requestPath): bool
    {
        if ($this->requestMethod() !== Route::ANY && mb_strtoupper($method) !== $this->requestMethod()) {
            return false;
        }

        $requestPath = trim($requestPath, "/");

        $this->nodes = $requestPath === '' ? [] : explode("/", $requestPath);

        $segments = explode("/", $this->pattern);

        if (count($segments) !== count($this->nodes)) {
            return false;
        }

        $allParams = [];
        foreach ($segments as $index => $name) {
            // variável
            if (str_starts_with($name, ":") === true) {
                $paramName = trim($name, ":");
                $allParams[$paramName] = $this->nodes[$index];
                continue;
            }

            // literal
            if ($name !== $this->nodes[$index]) {
                return false;
            }
        }

        $this->params = $allParams;

        return true;
    }
}

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

    private Closure|string $action = '';

    private string $method = 'GET';

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

    public function usingAction(Closure|string $action): Route
    {
        $this->action = $action;
        return $this;
    }

    public function usingMethod(string $method): Route
    {
        $this->method = strtoupper($method);
        return $this;
    }

    public function usingPattern(string $pattern): Route
    {
        $this->pattern = trim($pattern, "/");
        return $this;
    }

    public function action(): Closure|string
    {
        return $this->action;
    }

    public function method(): string
    {
        return $this->method;
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
        if ($this->method() !== Route::ANY && strtoupper($method) !== $this->method()) {
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
            // vari??vel
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

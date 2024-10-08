<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Routing\Route;
use Iquety\Routing\Router;
use Tests\TestCase;

class RouterTest extends TestCase
{
    /** @return array<int, array>) */
    public function routesNotMatchProvider(): array
    {
        $data = [];
        $listMethods = [ Route::ANY, Route::GET, Route::POST, Route::PUT, Route::DELETE ];

        foreach ($listMethods as $method) {
            $data[] = [ $method, 'edit/:id', "edit" ]; // tamanho diferente
            $data[] = [ $method, ':id', "edit/33" ]; // tamanho diferente

            $data[] = [ $method, 'edit/:id', "edit/33/show" ]; // tamanho e padrão diferentes
            $data[] = [ $method, ':id/edit', "33/edit/show" ]; // tamanho e padrão diferentes

            $data[] = [ $method, 'edit/:id', "edity/33" ]; // padrão diferente
            $data[] = [ $method, ':id/edit', "33/edity" ]; // padrão diferente
        }

        return $data;
    }

    /**
     * @test
     * @dataProvider routesNotMatchProvider
    */
    public function notMatch(string $method, string $pattern, string $path): void
    {
        $router = new Router();

        switch ($method) {
            case Route::ANY:
                $router->any($pattern);
                break;
            case Route::DELETE:
                $router->delete($pattern);
                break;
            case Route::GET:
                $router->get($pattern);
                break;
            case Route::PATCH:
                $router->patch($pattern);
                break;
            case Route::POST:
                $router->post($pattern);
                break;
            case Route::PUT:
                $router->put($pattern);
                break;
        }

        $this->assertFalse($router->routeNotFound());
        $this->assertNull($router->currentRoute());

        $router->process($method, $path);

        $this->assertTrue($router->routeNotFound());
        $this->assertNull($router->currentRoute());
    }

    /** @return array<int, array>) */
    public function routesMatchProvider(): array
    {
        $data = [];

        $listMethods = [
            Route::ANY,
            Route::DELETE,
            Route::GET,
            Route::PATCH,
            Route::POST,
            Route::PUT
        ];

        foreach ($listMethods as $method) {
            $data[] = [ $method, '/', "/" ];
            $data[] = [ $method, '', "" ];
            $data[] = [ $method, 'edit/:id', "edit/33" ];
            $data[] = [ $method, 'show/:name', "show/ricardo" ];
        }

        return $data;
    }

    /**
     * @test
     * @dataProvider routesMatchProvider
    */
    public function match(string $method, string $pattern, string $path): void
    {
        $router = new Router();

        switch ($method) {
            case Route::ANY:
                $router->any($pattern)->usingRequestMethod($method);
                break;
            case Route::DELETE:
                $router->delete($pattern)->usingRequestMethod($method);
                break;
            case Route::GET:
                $router->get($pattern)->usingRequestMethod($method);
                break;
            case Route::PATCH:
                $router->patch($pattern)->usingRequestMethod($method);
                break;
            case Route::POST:
                $router->post($pattern)->usingRequestMethod($method);
                break;
            case Route::PUT:
                $router->put($pattern)->usingRequestMethod($method);
                break;
        }

        $this->assertFalse($router->routeNotFound());
        $this->assertNull($router->currentRoute());

        $router->process($method, $path);

        $this->assertFalse($router->routeNotFound());
        $this->assertInstanceOf(Route::class, $router->currentRoute());
    }

    /** @test */
    public function contextualizedByModule(): void
    {
        $router = new Router();
        $router->get('/user/:name')->usingRequestMethod(Route::GET);

        $router->forModule('module_identifier');
        $router->get('/post/:id')->usingRequestMethod(Route::GET);

        $router->process(ROUTE::GET, '/user/ricardo');
        $this->assertInstanceOf(Route::class, $router->currentRoute());
        $this->assertEquals('all', $router->currentRoute()?->module());

        $router->process(ROUTE::GET, '/post/33');
        $this->assertInstanceOf(Route::class, $router->currentRoute());
        $this->assertEquals('module_identifier', $router->currentRoute()?->module());
    }
}

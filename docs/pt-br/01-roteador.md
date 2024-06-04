# Como usar o roteador

[◂ Índice da documentação](indice.md) | [Configurando rotas ▸](02-rota.md)
-- | --

## 1. Rota não encontrada

No exemplo a seguir, a solicitação do usuário por `produto/criar` não bate com
nenhuma rota definida. Então o método `routeNotFound` irá conter o valor `true`
e o método `currentRoute` conterá o valor `null`.

```php
$router = new Router();

// mapeia o URI '/usuario/editar/<algum-número>' para o verbo GET
$router->get('/usuario/editar/:id');

// tenta encontrar '/produto/criar' nas rotas mapeadas
$router->process('GET', '/produto/criar');

if ($router->routeNotFound() === true) {
    echo 'Este recurso não existe';
}
```

## 2. Rota encontrada

No exemplo a seguir o usuário solicitou que o roteador processe o URI
`/usuario/editar/33` com o verbo HTTP `GET`. No processo, o roteador identificará
que o URI bate com o padrão `/usuario/editar/:id` e irá determinar a rota atual,
que poderá ser obtida usando o método `currentRoute`.

```php
$router = new Router();

// mapeia o padrão '/usuario/editar/:id' para o verbo GET
$router->get('/usuario/editar/:id');

// verifica as rotas GET e tenta encontrar 
// '/usuario/editar/<algum-número>' nos padrões
$router->process('GET', '/usuario/editar/33');

// obtém a rota encontrada para usar suas informações
$currentRoute = $router->currentRoute();
```

## 3. Informações da rota encontrada

A rota encontrada, obtida pelo método `currentRoute`, fornece informações
importantes para decidir como responder à solicitação do usuário.

```php
$router = new Router();

$route = $router->currentRoute();

// nome completo da classe de ação ou função anônima
$actionClass = $route->action();

// nome do método da classe de ação
$actionMethod = $route->actionMethod();

// verbo referente à rota (GET,POST,PUT,PATCH,DELETE)
$httpMethod = $route->requestMethod();

// identificação do módulo
$moduleId = $route->module();

// parâmetros existentes na rota
$paramList = $route->params();

// padrão definido na rota ('/usuario/editar/:id')
$pattern = $route->pattern();
```

[◂ Índice da documentação](indice.md) | [Configurando rotas ▸](02-rota.md)
-- | --

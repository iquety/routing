# Configurando rotas

--page-nav--

## 1. Mapeando rotas

Através do roteador deve-se especificar as rotas que deverão ser analisadas para
identificar as solicitações do usuário. Os verbos disponíveis são:

```php
$router->any('...');
$router->get('...');
$router->post('...');
$router->put('...');
$router->patch('...');
$router->delete('...');
```

> Obs: O método `any` é especial e representa qualquer verbo proveniente da
solicitação do usuário.

Os métodos `any`, `get`, `post`, `put`, `patch` e `delete`, que definem as rotas,
são fluentes e retornam um objeto `Route`, que é usado para passar configurações
à rota.

## 2. Definindo a rotina de ação

A rotina a ser executada, quando a rota bater com a solicitação do usuário, é 
definida com o método `usingAction`:

```php
$router = new Router();

$router->get('/usuario/editar/:id')
       ->usingAction(UserController::class, 'edit');
```

No exemplo acima, o método `edit` da classe `UserController` é mapeado para o
URI `/usuario/editar/<algum-número>` quando o verbo HTTP usado for `GET`.

Também é possível definir uma rotina diretamente através de uma função anônima:

```php
$router = new Router();

$router->get('/usuario/editar/:id')->usingAction(function() {
    return 'olá';
});
```

No exemplo acima, o callback será mapeado para o URI `/usuario/editar/<algum-número>`
quando o verbo HTTP usado for `GET`.

## 3. Definindo a identificação do módulo

Quando implementando um sistema com módulos, pode ser interessante saber de
qual módulo a rota originou-se. Para isso, ao declarar a rota, pode-se definir
essa informação:

```php
$router = new Router();

$router->any('...')
    ->forModule('identificação do meu módulo');
```

--page-nav--

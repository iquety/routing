# Inicialização

--page-nav--

## A aplicação

O Docmap é um interpretador, que analisa um projeto de documentação em markdown.

```php
<?php

declare(strict_types=1);

use Freep\Application\Application;
use Freep\Application\Bootstrap;
use Freep\Application\Routing\Router;
use Modules\Admin\AdminBootstrap;
use Modules\Articles\ArticlesBootstrap;

$app = Application::instance();

// adiciona um bootstrap
$app->bootApplication(new AppBootstrap());

// o boot configura as rotas e as dependências
// locais dos módulos
$app->bootModule(new AdminBootstrap());
$app->bootModule(new ArticlesBootstrap());

$response = $app->run();

$app->sendResponse($response);
```

--page-nav--
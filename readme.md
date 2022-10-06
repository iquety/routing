# Freep Application

![PHP Version](https://img.shields.io/badge/php-%5E8.0-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/5a911e53f0cc421282d847d323f50203)](https://www.codacy.com/gh/ricardopedias/freep-console/dashboard?utm_source=github.com&utm_medium=referral&utm_content=ricardopedias/freep-console&utm_campaign=Badge_Coverage)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5a911e53f0cc421282d847d323f50203)](https://www.codacy.com/gh/ricardopedias/freep-console/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ricardopedias/freep-console&amp;utm_campaign=Badge_Grade)

[English](readme.md) | [Português](./docs/pt-br/leiame.md)
-- | --

## Synopsis

**Freep Application** is a library for creating modular applications using MVC and Hexagonal (Ports and Adapters) architectural patterns.

```bash
composer require ricardopedias/freep-application
```

### Application

* Provides separation of concerns (SOC), using bootable modules;
* Based on the MVC architectural pattern;
* Extremely flexible dependencies, using Hexagonal architecture (Ports and Adapters).

### Module

- Can define your own routes;
- Can define your own dependencies;
- Its dependencies are fabricated only if a module route is accessed;
- Loads Controllers and Policies using the Inversion of Control pattern.

For detailed information, see [Documentation Summary](docs/en/index.md).

## Characteristics

- Made for PHP 8.0 or higher;
- Codified with best practices and maximum quality;
- Well documented and IDE friendly;
- Made with TDD (Test Driven Development);
- Implemented with unit tests using PHPUnit;
- Made with :heart: &amp; :coffee:.

## Credits

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)

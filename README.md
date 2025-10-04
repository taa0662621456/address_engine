## Installation

Install via Composer:

```bash
composer require your-org/address-engine
```


# Address Component

[![PHP Tests & Coverage](https://github.com/your-username/your-repo/actions/workflows/tests.yml/badge.svg)](https://github.com/your-username/your-repo/actions/workflows/tests.yml)
[![codecov](https://codecov.io/gh/your-username/your-repo/branch/main/graph/badge.svg?token=YOUR_CODECOV_TOKEN)](https://codecov.io/gh/your-username/your-repo)

## Описание
Коммерческий Address-компонент:
- Entity + Repository + Service + DTO/ResponseDTO
- Engine (Country/Subdivision/Format/Validator)
- Полный набор тестов (unit, integration, functional, e2e)
- GitHub Actions CI + Code Coverage

## Запуск тестов
```bash
vendor/bin/phpunit --coverage-html build/coverage-html
```

## CI/CD
- Автоматические тесты и coverage при каждом push/PR.
- Статусы видны в бейджах выше.


## QA & Reports

### PHPUnit
Запуск юнит, интеграционных, функциональных и e2e тестов:
```bash
vendor/bin/phpunit --coverage-html build/coverage-html
```

### Behat (BDD)
Запуск бизнес-сценариев:
```bash
vendor/bin/behat --strict --no-interaction
```

### Allure Reports
1. Запустить тесты (PHPUnit и Behat), чтобы сформировались результаты в `build/allure-results`.
2. Поднять Allure Report локально:
```bash
docker-compose -f docker-compose.allure.yml up --build
```
3. Открыть в браузере: [http://localhost:8080](http://localhost:8080)

### CI/CD
- GitHub Actions и GitLab CI автоматически собирают тесты и выгружают результаты Allure.


### Demo Allure Report
Пример отчёта доступен локально: [docs/allure-sample/index.html](docs/allure-sample/index.html)  
![Allure Sample](docs/allure-sample/allure-sample.png)


## Quality & Coverage

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=address_engine&metric=alert_status)](https://sonarcloud.io/dashboard?id=address_engine)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=address_engine&metric=coverage)](https://sonarcloud.io/dashboard?id=address_engine)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=address_engine&metric=code_smells)](https://sonarcloud.io/dashboard?id=address_engine)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=address_engine&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=address_engine)


## Static Analysis

[![PHPStan](https://github.com/your-org/address_engine/actions/workflows/static-analysis.yml/badge.svg?branch=main&event=push)](https://github.com/your-org/address_engine/actions/workflows/static-analysis.yml)
[![Psalm](https://github.com/your-org/address_engine/actions/workflows/static-analysis.yml/badge.svg?branch=main&event=push)](https://github.com/your-org/address_engine/actions/workflows/static-analysis.yml)
[![Dependabot](https://img.shields.io/badge/dependabot-enabled-brightgreen.svg)](https://github.com/your-org/address_engine/network/updates)


### Static Analysis Reports Demo
- [PHPStan Sample](docs/static-analysis-sample/phpstan-sample.html)
- [Psalm Sample](docs/static-analysis-sample/psalm-sample.html)


## Dev Workflow

### Pre-commit Hooks
В проекте настроены pre-commit проверки:
- ✅ Lint PHP файлов
- ✅ PHPStan (strict mode)
- ✅ Psalm (static analysis)
- ✅ PHPUnit (unit/integration tests)

Хуки можно запускать вручную:
```bash
composer lint
composer phpstan
composer psalm
composer test
```

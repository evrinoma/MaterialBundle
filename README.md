# Installation

Добавить в kernel

    Evrinoma\MaterialBundle\EvrinomaMaterialBundle::class => ['all' => true],

Добавить в routes

    material:
        resource: "@EvrinomaMaterialBundle/Resources/config/routes.yml"

Добавить в composer

    composer config repositories.dto vcs https://github.com/evrinoma/DtoBundle.git
    composer config repositories.dto-common vcs https://github.com/evrinoma/DtoCommonBundle.git
    composer config repositories.utils vcs https://github.com/evrinoma/UtilsBundle.git

# Configuration

преопределение штатного класса сущности

    material:
        db_driver: orm модель данных
        factory: App\Material\Factory\MaterialFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Material\Entity\Material сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto: App\Material\Dto\MaterialDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд материала
          query - декоратор mediator запросов материала
        services:
          pre_validator - переопределение сервиса валидатора материала
          handler - переопределение сервиса обработчика сущностей
          file_system - переопределение сервиса сохранения файла

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_MATERIAL, API_CRITERIA_MATERIAL - получение материала
    2. API_POST_MATERIAL - создание материала
    3. API_PUT_MATERIAL -  редактирование материала

# Статусы:

    создание:
        материал создан HTTP_CREATED 201
    обновление:
        материал обновлен HTTP_OK 200
    удаление:
        материал удален HTTP_ACCEPTED 202
    получение:
        материал найден HTTP_OK 200
    ошибки:
        если материал не найден MaterialNotFoundException возвращает HTTP_NOT_FOUND 404
        если материал не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если материал не прошел валидацию MaterialInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если материал не может быть сохранен MaterialCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности material нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.material.constraint.property

    evrinoma.material.constraint.property.custom:
        class: App\Material\Constraint\Property\Custom
        tags: [ 'evrinoma.material.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
   
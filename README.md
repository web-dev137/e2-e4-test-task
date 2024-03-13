Тестовое задание PHP:

Необходимо реализовать микросервис загрузки курсов валют.
На входе:
• API смежной системы, которое возвращает курсы валют на текущую дату в формате XML. Можно использовать например API ЦБ http://www.cbr.ru/scripts/XML_daily.asp
Нужно:
• Загрузить данные по курсам
• Реализовать RESТ JSON API для выгрузки данных по курсам
• Необходимо сохранять историю курсов валют
• Необходимо сократить кол-во запросов в смежную систему

Формат входных и выходных данных предлагается разработать самостоятельно.

● предпочтительнее реализовать без использования framework

DIRECTORY STRUCTURE
-------------------

      app/                contains files of this application
      app/console         contains console commands (handlers)
      app/db              contains console commands (controllers)
      app/docs            contains console commands (controllers)
      app/handlers        contains handlers for actions
      app/handlers/api    contains handlers for api
      app/models          contains model classes
      app/utils           contains utilits for work freamwork
      app/views           contains view files for the Web application
      config/             contains application configurations
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.0.0


INSTALLATION
------------

### Install

- Download project
~~~
git clone <project-path>
~~~
- Rename all config/*.example files to config/<filename>.php
- Create database 
- Pull up all dependencies
~~~
composer install
~~~
- Apply sql scripts for create tables in app/db/db_scripts
- Add data from Central Bank of Russia
~~~
php command.php -c update-courses
~~~


TESTING
-------
Tests are located in `tests` directory.

- In first, you should set constant APP_MODE_TEST to true in index.php (in root directory)
- Create converter_test database and execute sql scripts(app/db/db_scripts) for this database
- Execute scripts in app/db/db_scripts for fill data into tables of test database.
```
php vendor/bin/codecept run  Api ConverterApiCest
```
The command above will execute tests for this api. 

ABOUT THIS FRAMEWORK
--------------------
This framework implements ideas and concepts from various
php frameworks and individual microservices architecture services.
Routing:
- Route sets in config file in route section, route format: 
~~~
<host>/<your uri>
~~~
- Route for console commands in console/route section, command format:
~~~
php command.php -c <your command>
~~~
Database instance sets in the entry script(index.php), configurations you can set in file config.php
Models has method "load" for load post data(if post params exist), has property protected db property that 
setting from db instance from App::$db.
Class Db has while two methods for batch insert and clear tables also
this class has property pdo of class PDO.




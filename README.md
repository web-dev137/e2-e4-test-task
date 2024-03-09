This project is solve of the test task for php developer vacancy.
Task was in create RESTful API for blog.
The API for the blog included the following requirements:
1. Sign up and login for users.
2. For authorized users available CRUD for posts.
Each post has status(private,public,auth), where:
public - visible for all(include guests),
auth - visible for authorized users,
private - visible for author of post.
3.The ability to reply / comment on the message.

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
- Route sets in config file in route section, route format: <host>/<your uri>
- Route for console commands in console/route section, command format: php command.php -c <your command>
Database instance sets in the entry script(index.php), configurations you can set in file config.php
Models has method "load" for load post data(if post params exist), has property protected db property that 
setting from db instance from App::$db.
Class Db has while two methods for batch insert and clear tables also
this class has property pdo of class PDO.




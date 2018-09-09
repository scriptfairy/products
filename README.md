# Product Management Demo


## Frameworks

* Back end code is written with CakePHP 3.6

* Front end code is written with Vue.js

## Steps to setup the application

* Follow the instructions in https://book.cakephp.org/3.0/en/quickstart.html to start a project with CakePHP.

* Install MySql and create a schema called brighte, create a new table:

```
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `created` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

```

* Make sure PHPUnit is installed on your machine, otherwise follow the instructions in this page:

https://book.cakephp.org/3.0/en/development/testing.html



You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Configuration

Read and edit `config/app.php` and setup the `'Datasources'`

```
'Datasources' => [
    'default' => [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'username' => 'brighte',
        'password' => 'brighte',
        'database' => 'brighte',
        'timezone' => 'UTC',
        'flags' => [],
        'cacheMetadata' => true,
        'log' => false,
        'quoteIdentifiers' => false,
        'url' => env('DATABASE_URL', null),
    ],

```

Update routes.php :

```
$routes->connect('/', ['controller' => 'Products', 'action' => 'index', 'index']);

```

## Test Case:

To run the test case:

```
vendor/bin/phpunit -v tests/TestCase/Controller/ProductsControllerTest
```

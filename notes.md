# CakePHP Unit Testing setup

* After installing CakePHP in brighte dir, do the following:

```
  cd brighte
  composer require --dev phpunit/phpunit:"^5.7|^6.0"
```

You can run the unit test with this command

```
$ vendor/bin/phpunit
```

* Install MySql db

first we need to have xcode installed

```
sudo xcode-select -s /Applications/Xcode.app/Contents/Developer

sudo xcodebuild -license
```

* We need Homebrew (it is already installed):

```
brew help

brew install mysql
```

This will download mysql 8.0.12

To start MySql

```
mysql.server start
```

To run a testing
```
 avendor/bin/phpunit tests/TestCase/Controller/PagesControllerTest
```

Create a new table called product

```
CREATE TABLE product
(
  id int not null auto_increment primary key,
  name varchar(250) not null,
  picture varchar(500) not null,
  price decimal(10,2),
  description varchar(1000) not null,
  created DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
  updated timestamp default now() on update now()
);
```

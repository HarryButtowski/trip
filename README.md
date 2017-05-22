Командировка
============================

Ведение учета командировок сотрудников


ТРЕБОВАНИЯ
------------

Проект выполнен на Yii 2.0, PHP 7.0


УСТАНОВКА
------------

Установите проект командой:

~~~
git clone http://github.com/HarryButtowski/trip.git trip
~~~

Перейдите во вновь созданный каталог `trip` и выполните команды по порядку:
~~~
composer install
~~~


НАСТРОЙКА
-------------

### База данных

Отредактируйте файл `config/db.php` заполнив актуальными данными, для примера:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

Для создания необходимых таблиц выполните команду:
~~~
php yii migrate/up
php yii migrate --migrationPath=@yii/rbac/migrations
php yii rbac/init
~~~

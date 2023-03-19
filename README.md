# impersonate
Impersonate Laravel Package

# config/app.php

В массив providers в провайдеры пакетов добавить:

``` php
  \D2my\Impersonate\Providers\ImpersonateServiceProvider::class,
```

# Опубликовать конфиг

```
  php artisan vendor:publish --tag=impersonate
```

# config/impersonate.php

Настроить конфиг

# Запустить миграцию

```
  php artisan migrate
```

# Роуты

Login (POST)

```php
  route('impersonate.login', ['id' => $id])
```

Logout (DELETE)

```php
  route('impersonate.logout')
```

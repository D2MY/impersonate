<?php

return [

    //Подключение к базе с юзерами
    'connection' => 'mysql',

    // Guard из config/auth.php, определяющий способ авторизации
    'user_guard' => 'web',

    //название гейта для проверки доступности логина под другим юзером
    'gate' => null,

    'logging' => [
        'enable' => false,

        //канал логирования
        'channel' => null
    ],

    'table' => [
        // Название таблицы с токенами
        'name' => 'impersonate_tokens',

        'identifier' => [
            // Тип столбца идентификатора юзеров
            'type' => 'unsignedBigInteger',

            // Дополнительные опции для поля идентификатора
            // $table->{config('impersonate.table_identifier_type')}('admin', ...\Illuminate\Support\Arr::wrap(config('impersonate.table_identifier_options')));
            'options' => [],
        ],
    ],

    'route' => [
        'login' => [
            // Сохранять урл страницы откуда происходил логин
            'save_location' => true,

            // Ключ сессии для сохранения урла
            'session_name' => 'impersonate.login.location',

            // Middleware для роута логина, в группе обязательно должен быть миддлвар старта сессии
            'middleware' => ['web', \D2my\Impersonate\Http\Middleware\ImpersonateLogin::class],

            // Имя роута логина
            'name' => 'impersonate.login',

            // Урл для редиректа после логина
            'redirect' => 'profile',
        ],
        'logout' => [
            // Middleware для роута логаута, в группе обязательно должен быть миддлвар старта сессии
            'middleware' => ['web', \D2my\Impersonate\Http\Middleware\ImpersonateLogout::class],

            // Имя роута логаута
            'name' => 'impersonate.logout',

            // Урл для редиректа после логаута
            'redirect' => 'admin',
        ],
    ],

    // Удалять запись из таблицы о токене после логаута
    'delete_after_logout' => false,

];

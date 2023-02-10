<?php

return [

    'migrate' => false,

    'table_identifier_type' => 'unsignedBigInteger',

    'table_identifier_options' => [],

    'table' => 'impersonate_tokens',

    'login_middleware' => [],

    'login_name' => 'impersonate.login',

    'login_redirect' => 'profile',

    'logout_middleware' => [],

    'logout_name' => 'impersonate.logout',

    'logout_redirect' => 'admin',

    'delete_after_logout' => true,

];

//app(\D2my\Impersonate\Services\ImpersonateService::class)->existsByToken(Cookie::get('impersonate_token'))
<?php

return [
    'title'=> env('APP_NAME'),
    'dashboard_url' => '/',
    'logout_method' => 'GET',
    'logout_url' => '/logout',
    'login_url' => '/',
    'menu' => [
        [
            'text' => 'Movimentos',
            'url' => '/movimentos',
            'can' => '',
        ],
        [
            'text' => 'Áreas',
            'url' => '/areas',
            'can' => '',
        ],
        [
            'text' => 'Tipos de Contas',
            'url' => '/tipocontas',
            'can' => '',
        ],
        [
            'text' => 'Dotações Orçamentárias',
            'url' => '/dotorcamentarias',
            'can' => '',
        ],

    ]
];

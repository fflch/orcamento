<?php

return [
    'title'=> env('APP_NAME'),
    'dashboard_url' => '/movimentos',
    'logout_method' => 'POST',
    'logout_url' => '/logout',
    'login_url' => '/login',
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
        [
            'text' => 'Contas',
            'url' => '/contas',
            'can' => '',
        ],
    ]
];
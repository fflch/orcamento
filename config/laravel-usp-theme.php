<?php
/*
$administracao = [
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
];
*/
return [
    'title'=> env('APP_NAME'),
    'dashboard_url' => '/movimentos',
    'logout_method' => 'POST',
    'logout_url' => '/logout',
    'login_url' => '/login',
    'menu' => [
        /*[
            'text' => 'Administração',
            'submenu' => $administracao,
            'can' => ''
        ],*/
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
        [
            'text' => 'Notas',
            'url' => '/notas',
            'can' => '',
        ],
        [
            'text' => 'Lançamentos',
            'url' => '/lancamentos',
            'can' => '',
        ],
        [
            'text' => 'Ficha Orçamentária',
            'url' => '/ficorcamentarias',
            'can' => '',
        ],
        [
            'text' => 'ContasxUsuários',
            'url' => '/contausuarios',
            'can' => '',
        ],
    ]
];
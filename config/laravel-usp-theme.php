<?php
$right_menu = [
    [
        'text'   => '<i class="fas fa-hard-hat"></i>',
        'title'  => 'Logs',
        'target' => '_blank',
        'url'    => config('app.url') . '/logs',
        'align'  => 'right',
        'can'    => 'Administrador',
    ],
];
$administracao = [
    [
        'text'    => 'Lançamentos',
        'url'     => '/lancamentos',
        'can'     => 'Todos',
    ],
    [
        'text'    => 'Fichas Orçamentárias',
        'url'     => '/ficorcamentarias',
        'can'     => 'Todos',
    ],
    [
        'type' => 'divider',
        'can'  => 'Todos',
    ],
    [
        'text' => 'Movimentos',
        'url'  => '/movimentos',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Tipos de Contas',
        'url'  => '/tipocontas',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Contas',
        'url'  => '/contas',
        'can'  => 'Todos',
    ],
    [
        'text' => 'Dotações Orçamentárias',
        'url'  => '/dotorcamentarias',
        'can'  => 'Todos',
    ],
    [
        'text' => 'Notas',
        'url'  => '/notas',
        'can'  => 'Todos',
    ],
    [
        'text' => 'Usuários',
        'url'  => '/usuarios',
        'can'  => 'Todos',
    ],
    [
        'type' => 'divider',
        'can'  => 'Todos',
    ],
    [
        'type' => 'header',
        'text' => '<b><i class="fas fa-id-badge"></i> Configurações</b>',
        'can' => 'Todos',
    ],
    [
        'text' => 'Unidade',
        'url'  => '/unidades',
        'can'  => 'Todos',
    ],
];
return [
    'title'=> env('APP_NAME'),
    'dashboard_url'   => config('app.url'),
    'app_url' => config('app.url'),
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'right_menu' => $right_menu,

    'menu'            => [
        [
            'text'    => '<i class="far fa fa-plus"></i> Lançamentos',
            'url'     => '/lancamentos/create',
            'can'     => 'Todos',
        ],
        [
            'text'    => '<i class="far fa fa-plus"></i> Ficha Orçamentária',
            'url'     => '/ficorcamentarias/create',
            'can'     => 'Todos',
        ],
        [
            'text'    => '<i class="far fa-list-alt"></i> Relatórios',
            'url'     => '/relatorios',
            'can'     => 'Todos',
        ],
        [
            'text'    => 'Administração',
            'submenu' => $administracao,
            'can'     => 'Todos',
        ],
    ]
];

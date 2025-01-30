<?php
$right_menu = [
    [
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
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
        'can'     => 'Administrador',
    ],
    [
        'text'    => 'Fichas Orçamentárias',
        'url'     => '/ficorcamentarias',
        'can'     => 'Administrador',
    ],
    [
        'type' => 'divider',
        'can'  => 'Administrador',
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
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Dotações Orçamentárias',
        'url'  => '/dotorcamentarias',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Notas',
        'url'  => '/notas',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Usuários',
        'url'  => '/usuarios',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Projetos Especiais - Importação',
        'url'  => '/importacao',
        'can'  => 'Administrador',
    ],
    [
        'type' => 'divider',
        'can'  => 'Administrador',
    ],
    [
        'type' => 'header',
        'text' => '<b><i class="fas fa-id-badge"></i> Configurações</b>',
        'can' => 'Administrador',
    ],
    [
        'text' => 'Unidade',
        'url'  => '/unidades',
        'can'  => 'Administrador',
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
            'can'     => 'Administrador',
        ],
        [
            'text'    => '<i class="far fa fa-plus"></i> Ficha Orçamentária',
            'url'     => '/ficorcamentarias/create',
            'can'     => 'Administrador',
        ],
        [
            'text'    => '<i class="far fa-list-alt"></i> Relatórios',
            'url'     => '/relatorios',
            'can'     => 'Administrador',
        ],
        [
            'text'    => 'Administração',
            'submenu' => $administracao,
            'can'     => 'Administrador',
        ],
        [
            'text' => 'Minhas contas',
            'url'  => '/home_usuario',
            'can'  => 'Todos',
        ],
    ]
];

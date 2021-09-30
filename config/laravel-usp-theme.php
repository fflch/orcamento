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
        'text' => 'Movimentos',
        'url'  => '/movimentos',
        'can'  => 'Administrador',
    ],
    [
        'text' => 'Áreas',
        'url'  => '/areas',
        'can'  => 'Todos',
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
        'text' => 'Contas x Usuários',
        'url'  => '/contausuarios',
        'can'  => 'Administrador',
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
    'logout_method'   => 'POST',
    'logout_url'      => '/logout',
    'login_url'       => '/login',
    'right_menu'      => $right_menu,
    'menu'            => [
        [
            'text'    => 'Administração',
            'submenu' => $administracao,
            'can'     => 'Todos',
        ],
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
    ]
];

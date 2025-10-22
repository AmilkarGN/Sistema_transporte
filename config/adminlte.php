<?php

return [


    'title' => 'Sistema de Tranporte  ',
    'title_prefix' => '',
    'title_postfix' => '',


    'use_ico_only' => false,
    'use_full_favicon' => false,



    'google_fonts' => [
        'allowed' => true,
    ],

   

    'logo' => '<b>Sistema de</b>Tranporte',
    'logo_img' => 'vendor/adminlte/dist/img/Logo1.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',



    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/Logo1.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

   

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/Logo1.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

   

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,


    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,


    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',


    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',



    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,



    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',



    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,



    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',


    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],

        [
            'text' => 'Usuarios',
            'url'  => 'users',
            'icon' => 'fas fa-users',
            'can' => 'Ver Boton Usuarios',

        ],

        [
            'text' => 'Roles',
            'url'  => 'roles',
            'icon' => 'fas fa-user-tag',
            'can' => 'Ver Boton Roles',
        ],
        [
            'text' => 'Clientes',
            'url'  => 'clients',
            'icon' => 'fas fa-users',
            'can' => 'Ver Boton Clientes',
        ],
        [
            'text' => 'Conductores',
            'url'  => 'drivers',
            'icon' => 'fas fa-id-card',
            'can' => 'Ver Boton Conductores',
        ],
        [
            'text' => 'Vehículos',
            'url'  => 'vehicles',
            'icon' => 'fas fa-car',
            'can' => 'Ver Boton Vehiculos',
        ],
        [
            'text' => 'Asignación Vehículos',
            'url'  => 'vehicle-assignments',
            'icon' => 'fa fa-car',
            'can' => 'Ver Boton Asignacion Vehiculos',
        ],
        [
            'text' => 'Rutas',
            'url'  => 'routes',
            'icon' => 'fas fa-map-signs',
            'can' => 'Ver Boton Rutas',
        ],
        [
            'text' => 'Envios',
            'url'  => 'shipments',
            'icon' => 'fas fa-shipping-fast',
            'can' => 'Ver Boton Envios',
        ],
        [
            'text' => 'Envios Asignados',
            'url'  => 'shipment-assignments',
            'icon' => 'fas fa-truck',
            'can' => 'Ver Boton Envios Asignados',
        ],
        [
            'text' => 'Peajes',
            'url'  => 'toll-booths',
            'icon' => 'fas fa-road',
            'can' => 'Ver Boton Peajes',
        ],
        [
            'text' => 'Viajes',
            'url'  => 'trips',
            'icon' => 'fas fa-route',
            'can' => 'Ver Boton Viajes',
        ],
        [
            'text' => 'Reservas',
            'url'  => 'bookings',
            'icon' => 'fas fa-calendar-alt',
            'can' => 'Ver Boton Reservas',
        ],
        [
            'text' => 'Calendario Reservas',
            'url'  => 'booking/calendar',
            'icon' => 'fas fa-calendar',
            'can' => 'Ver Boton Calendario Reservas',
        ],
        ['header' => 'account_settings'],
        [
            'text' => 'Ver Perfil',
            'url'  => 'perfil',
            'icon' => 'fas fa-user',
        ],
        [
            'text' => 'Editar Perfil',
            'url'  => 'profile',
            'icon' => 'fas fa-user-edit',
        ],
        [
            'text' => 'change_password',
            'url' => 'admin/settings',
            'icon' => 'fas fa-fw fa-lock',
        ],
        
    ],

  

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        [
            'text' => 'Usuarios',
            'url'  => 'users',
            'icon' => 'fas fa-users',
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

   

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        [
            'text' => 'Usuarios',
            'url'  => 'users',
            'icon' => 'fas fa-users',
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],
    'livewire' => false,
];

<?php
return array(    

    'view_manager' => array(
        'template_path_stack' => array(
            'crunchysignup' => __DIR__ . '/../view',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'crunchyregister_r_controller' => 'CrunchySignup\Controller\RegisterController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'child_routes' => array(
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'crunchyregister_r_controller',
                                'action'     => 'register',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'confirm-email' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/email-confirmation',
                                    'defaults' => array(
                                        'controller' => 'crunchyregister_r_controller',
                                        'action'     => 'register',
                                    ),
                                ),
                             ),
                            'check-token' => array(
                                'type' => 'Regex',
                                'options' => array(
                                    'regex' => '/token-verification/(?<token>[A-F0-9]+)',
                                    'defaults' => array(
                                        'controller' => 'crunchyregister_r_controller',
                                        'action'     => 'check-token',
                                    ),
                                    'spec' => '/token-verification/%token%',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

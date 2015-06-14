<?php
return array(
    'routes' => array(
        'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/',
                'defaults' => array(
                    'controller' => 'Maps\Controller\Index',
                    'action' => 'index',
                ),
            ),
        ),

        'index-tracks' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/tracks',
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'index',
                ),
            ),
        ),

        'add-track' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/track/add',
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'add',
                ),
            ),
        ),

        'view-track' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/track/view/:track_id',
                'constraints' => array(
                    'track_id' => '\d+',
                ),
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'view',
                ),
            ),
        ),

        'get-track' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/track/get/:track_id',
                'constraints' => array(
                    'track_id' => '\d+',
                ),
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'getGpx',
                ),
            ),
        ),

        'delete-track' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/track/delete/:track_id',
                'constraints' => array(
                    'track_id' => '\d+',
                ),
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'delete',
                ),
            ),
        ),

        'login-user' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/login',
                'defaults' => array(
                    'controller' => 'Maps\Controller\User',
                    'action' => 'login',
                ),
            ),
        ),

        'login-ajax-user' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/login/ajax',
                'defaults' => array(
                    'controller' => 'Maps\Controller\User',
                    'action' => 'loginAjax',
                ),
            ),
        ),

        'logout-user' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/logout',
                'defaults' => array(
                    'controller' => 'Maps\Controller\User',
                    'action' => 'logout',
                ),
            ),
        ),

        'logout-ajax-user' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/logout/ajax',
                'defaults' => array(
                    'controller' => 'Maps\Controller\User',
                    'action' => 'logoutAjax',
                ),
            ),
        ),

    ),
);
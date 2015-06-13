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
                    'action' => 'indexTrack',
                ),
            ),
        ),

        'add-track' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/track/add',
                'defaults' => array(
                    'controller' => 'Maps\Controller\Track',
                    'action' => 'addTrack',
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
                    'action' => 'viewTrack',
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
                    'action' => 'getTrack',
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

    ),
);
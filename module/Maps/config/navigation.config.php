<?php
return array(
    'default' => array(
        array(
            'label' => 'Home',
            'route' => 'home',
            'icon'  => 'glyphicon glyphicon-home',
            'resource'  => 'Index',
            'privilege' => 'index',
        ),

        array(
            'label' => 'Tracks',
            'route' => 'index-tracks',
            'icon'  => 'glyphicon glyphicon-home',
            'resource'  => 'Track',
            'privilege' => 'indexTrack',
        ),

        array(
            'label' => 'Add track',
            'route' => 'add-track',
            'icon'  => 'glyphicon glyphicon-home',
            'resource'  => 'Track',
            'privilege' => 'addTrack',
        ),


        array(
            'label' => 'User',
            'uri' => '#',
            'icon' => 'glyphicon glyphicon-home',
            'pages' => array(
                array(
                    'label' => 'Login',
                    'route' => 'login-user',
                    'icon' => 'glyphicon glyphicon-home',
                    'resource' => 'User',
                    'privilege' => 'login',
                ),
                array(
                    'label' => 'Logout',
                    'route' => 'logout-user',
                    'icon' => 'glyphicon glyphicon-home',
                    'resource' => 'User',
                    'privilege' => 'logout',
                ),
            ),
        ),
        
    )
);

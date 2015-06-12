<?php
return array(
    'default' => array(
        array(
            'label' => 'Home',
            'route' => 'home',
            'icon'  => 'glyphicon glyphicon-home',
            /*'resource'  => 'Index',
            'privilege' => 'index',*/
        ),

        array(
            'label' => 'Tracks',
            'route' => 'index-tracks',
            'icon'  => 'glyphicon glyphicon-home',
        ),

        array(
            'label' => 'Add track',
            'route' => 'add-track',
            'icon'  => 'glyphicon glyphicon-home'
        ),

        /*
        array(
            'label' => 'Menu 2',
            'uri' => '#',
            'icon' => 'glyphicon glyphicon-home',
            'pages' => array(
                array(
                    'label' => 'Submenu',
                    'uri' => '#',
                    'icon' => 'glyphicon glyphicon-home'
                ),
                array(
                    'uri' => '#',
                    'separator' => true
                ),
                array(
                    'label' => 'Another Submenu',
                    'uri' => '#',
                    'icon' => 'glyphicon glyphicon-home'
                ),
            )
        ),
        */
    )
);

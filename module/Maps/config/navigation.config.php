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
            'icon'  => 'glyphicon glyphicon-th-list',
            'resource'  => 'Track',
            'privilege' => 'indexTrack',
        ),

        array(
            'label' => 'Add track',
            'route' => 'add-track',
            'icon'  => 'glyphicon glyphicon-plus',
            'resource'  => 'Track',
            'privilege' => 'addTrack',
        ),

    ),

);

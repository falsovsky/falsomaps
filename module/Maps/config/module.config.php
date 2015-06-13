<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Maps/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Maps\Entity' => 'application_entities'
                ),
            ),
        ),
    ),
    'router' => require __DIR__ .'/router.config.php',
    'navigation' => require __DIR__ .'/navigation.config.php',
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Maps\Controller\Index' => 'Maps\Controller\IndexController',
            'Maps\Controller\Track' => 'Maps\Controller\TrackController',
            'Maps\Controller\User'  => 'Maps\Controller\UserController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'setPageTitle'  => 'Maps\Controller\Plugin\PageTitlePlugin',
            'AclPlugin'     => 'Maps\Controller\Plugin\AclPlugin',
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'maps/index/index'        => __DIR__ . '/../view/maps/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);

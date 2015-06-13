<?php

namespace Maps\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class UserNavigation extends DefaultNavigationFactory
{

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $sessContainer = $serviceLocator
            ->get('Zend\Authentication\AuthenticationService')->getStorage()->read();

        $navigation = array();

        if (null === $this->pages) {
            $navigation[] = array (
                'label' => $sessContainer == NULL ? 'Hi visitor' : 'Hello, ' . $sessContainer->getUsername() . "!",
                'uri' => '#',
                //'icon' => 'glyphicon glyphicon-home',
                'pages' => array(
                    array(
                        'label' => 'Login',
                        'route' => 'login-user',
                        'icon' => 'glyphicon glyphicon-user',
                        'resource' => 'User',
                        'privilege' => 'login',
                    ),
                    array(
                        'label' => 'Logout',
                        'route' => 'logout-user',
                        'icon' => 'glyphicon glyphicon-log-out',
                        'resource' => 'User',
                        'privilege' => 'logout',
                    )
                )
            );

            $mvcEvent = $serviceLocator->get('Application')
                      ->getMvcEvent();

            $routeMatch = $mvcEvent->getRouteMatch();
            $router     = $mvcEvent->getRouter();
            $pages      = $this->getPagesFromConfig($navigation);

            $this->pages = $this->injectComponents(
                $pages,
                $routeMatch,
                $router
            );
        }

        return $this->pages;
    }
}
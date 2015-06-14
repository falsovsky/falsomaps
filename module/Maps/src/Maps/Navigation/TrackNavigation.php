<?php

namespace Maps\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class TrackNavigation extends DefaultNavigationFactory
{

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $sessContainer = $serviceLocator
            ->get('Zend\Authentication\AuthenticationService')->getStorage()->read();

        $navigation = array();

        if (null === $this->pages) {
            $navigation[] = array (
                'label' => "OIX",
                'uri' => '#',
                //'icon' => 'glyphicon glyphicon-home',
                'pages' => array(
                    array(
                        'label' => 'Edit',
                        'uri'   => '#',
                        //'route' => 'login-user',
                        //'icon' => 'glyphicon glyphicon-user',
                        //'resource' => 'Track',
                        //'privilege' => 'login',
                    ),
                    array(
                        'label' => 'Delete',
                        'uri'   => '#',
                        //'route' => 'logout-user',
                        //'icon' => 'glyphicon glyphicon-log-out',
                        //'resource' => 'User',
                        //'privilege' => 'logout',
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
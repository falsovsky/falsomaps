<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Maps;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Authentication\AuthenticationService;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_RENDER, function($e) {

            $flashMessenger = new FlashMessenger();

            if ($flashMessenger->hasSuccessMessages()) {
                $e->getViewModel()->setVariable('successMessages', $flashMessenger->getSuccessMessages());
            }

        });

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sharedManager  = $eventManager->getSharedManager();
        $serviceManager = $e->getApplication()->getServiceManager();

        $router       = $serviceManager->get('router');
        $request      = $serviceManager->get('request');
        $matchedRoute = $router->match($request);

        if (null !== $matchedRoute) {
            $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
                function($e) use ($serviceManager) {
                    $serviceManager->get('ControllerPluginManager')->get('AclPlugin')
                        ->doAuthorization($e); //pass to the plugin...
                }
            ,2);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }
}

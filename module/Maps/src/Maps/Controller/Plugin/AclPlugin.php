<?php

namespace Maps\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource,
    Zend\Permissions\Acl\Assertion\AssertionInterface,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Resource\ResourceInterface,
    Zend\Permissions\Acl\Role\RoleInterface;


class AclPlugin extends AbstractPlugin
{
    protected $sesscontainer;
    protected $acl;

    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = $this->getController()->getServiceLocator()
                ->get('Zend\Authentication\AuthenticationService')->getStorage()->read();
        }

        return $this->sesscontainer;
    }

    public function getAcl()
    {
        if (empty($this->acl)) {
            $this->acl = new Acl();

            $this->acl->addRole(new Role('visitor'));
            $this->acl->addRole(new Role('user'));

            $this->acl->addResource(new Resource('Index'));
            $this->acl->allow(array('visitor', 'user'), 'Index', array('index'));

            $this->acl->addResource(new Resource('User'));
            $this->acl->allow('visitor',  'User', array('login', 'loginAjax'));
            $this->acl->allow('user', 'User', array('logout', 'logoutAjax'));

            $this->acl->addResource(new Resource('Track'));
            $this->acl->allow(array('user'), 'Track');
            $this->acl->allow(array('visitor'), 'Track', array('index', 'view', 'getGpx'));
        }
        
        return $this->acl;
    }


    public function doAuthorization($e)
    {
        $this->getAcl();
        
        $roleName            = $this->getSessContainer() == NULL ? 'visitor' : $this->getSessContainer()->getRole();
        $controllerClassName = $e->getRouteMatch()->getParam('controller', 'index');
        $controllerName      = substr($controllerClassName, (strrpos($controllerClassName, "\\")+1) );
        $actionName          = $e->getRouteMatch()->getParam('action', 'index');

        \Zend\View\Helper\Navigation::setDefaultAcl($this->acl);
        \Zend\View\Helper\Navigation::setDefaultRole($roleName);

        if (!$this->acl->isAllowed($roleName, $controllerName, $actionName)) {

            $router = $e->getRouter();
            $url    = $router->assemble(array('controller' => 'index', 'action' => 'index'), array('name' => 'home'));

            $response = $e->getResponse();
            $response->setStatusCode(302);

            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }
    }
}
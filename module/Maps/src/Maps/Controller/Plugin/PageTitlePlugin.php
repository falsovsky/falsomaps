<?php
namespace Maps\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class PageTitlePlugin extends AbstractPlugin{

    public function setPageTitle($pageTitle)
    {
        $this->getController()->layout()->pageTitle = $pageTitle;
    }

    public function __invoke($pageTitle)
    {
        return $this->setPageTitle($pageTitle);
    }

}
<?php

namespace Maps\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->setPageTitle("Home");

        return new ViewModel(
            array()
        );
    }

}

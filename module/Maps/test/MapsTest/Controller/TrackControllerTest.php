<?php

namespace MapsTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class TrackControllerTest extends AbstractHttpControllerTestCase
{
    private $insertedTrackId;

    public function setUp()
    {
        $root = "C:\\xampp\\projects\\falsomaps\\";

        $this->setApplicationConfig(
            include $root . 'config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/tracks');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('maps');
        $this->assertControllerName('maps\controller\track');
        $this->assertControllerClass('TrackController');
        $this->assertMatchedRouteName('index-tracks');
    }

    public function testViewActionCanBeAccessed()
    {
        $this->dispatch('/track/view/5');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('maps');
        $this->assertControllerName('maps\controller\track');
        $this->assertControllerClass('TrackController');
        $this->assertMatchedRouteName('view-track');
    }

}
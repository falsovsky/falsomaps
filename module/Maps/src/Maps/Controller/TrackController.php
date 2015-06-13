<?php

namespace Maps\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter\File\Rename as RenameFilter;

use Maps\Form\AddTrackForm;
use Maps\Entity\Track;


class TrackController extends AbstractActionController
{
    private $sesscontainer;

    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = $this->getServiceLocator()
                ->get('Zend\Authentication\AuthenticationService')->getStorage()->read();
        }
        return $this->sesscontainer;
    }

    public function indexTrackAction()
    {
        $this->setPageTitle("All tracks");

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $tracks = $objectManager->getRepository('Maps\Entity\Track')->findAll();

        return new ViewModel(
            array(
                'tracks' => $tracks,
            )
        );
    }

    public function viewTrackAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $track = $objectManager->find('Maps\Entity\Track', $this->params('track_id'));
        if ($track === null) return $this->redirect()->toRoute('tracks');

        $this->layout('layout/map-layout');
        $this->layout()->title = $track->getStart() . " - " . $track->getFinish();

        return new ViewModel(
            array(
                'track' => $track,
            )
        );
    }

    public function addTrackAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $this->setPageTitle("Add new track");

        $form = new AddTrackForm($objectManager);

        $track = new Track();
        $form->bind($track);

        if ($this->request->isPost()) {

            $postData = array_merge_recursive(
                (array)$this->request->getPost(),
                (array)$this->request->getFiles()
            );

            $form->setData($postData);

            if ($form->isValid()) {

                $user = $objectManager->find('Maps\Entity\User', $this->getSessContainer()->getId());
                $track->setUser($user);
                $track->setCreatedAt(new \DateTime("now"));
                $track->setFilename($track->getFilename()['tmp_name']);

                $objectManager->persist($track);
                $objectManager->flush();

                $newPath = $this->getGpxPath($track->getId());
                $filter = new RenameFilter($newPath);
                $filter->filter($track->getFilename());
                $track->setFilename($newPath);
                
                $objectManager->flush();

                return $this->redirect()->toRoute('index-tracks');
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
            )
        );
    }


    public function deleteTrackAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $track = $objectManager->find('Maps\Entity\Track', $this->params('track_id'));
        if ($track === null) return $this->redirect()->toRoute('tracks');

        $path = $track->getFilename();
        if (file_exists($path)) {
            unlink($path);
        }

        $objectManager->remove($$track);
        $objectManager->flush();

        return $this->redirect()->toRoute('tracks');
    }

    public function getTrackAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $track = $objectManager->find('Maps\Entity\Track', $this->params('track_id'));
        if ($track === null) return $this->redirect()->toRoute('tracks');

        $file = $track->getFilename();
        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }

    private function getGpxPath($id)
    {
        return $newPath = "./data/tracks/track_{$id}.gpx";
    }

}

<?php
namespace Maps\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class AddTrackForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('add-track-form');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $trackFieldset = new TrackFieldset($objectManager);
        $trackFieldset->setUseAsBaseFieldset(true);
        $this->add($trackFieldset);

        $this->add(array(
            'name'       => 'button-submit',
            'type'       => 'button',
            'attributes' => array('type' => 'submit'),
            'options'    => array(
                'label' => 'Submit',
                //'column-size' => 'sm-10 col-sm-offset-1',
            )
        ));
    }
}
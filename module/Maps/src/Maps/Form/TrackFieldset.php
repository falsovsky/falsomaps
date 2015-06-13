<?php
namespace Maps\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

use Maps\Entity\Track;

class TrackFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('track');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new Track());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'start',
            'options' => array(
                'label' => 'Start',
                'column-size'      => 'sm-2',
                'label_attributes' => array('class' => 'col-sm-1')
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'finish',
            'options' => array(
                'label' => 'Finish',
                'column-size'      => 'sm-2',
                'label_attributes' => array('class' => 'col-sm-1')
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'device',
            'options' => array(
                'label' => 'Device',
                'column-size'      => 'sm-2',
                'label_attributes' => array('class' => 'col-sm-1')
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'filename',
            'options' => array(
                'label'            => 'File',
                'column-size'      => 'sm-2',
                'label_attributes' => array('class' => 'col-sm-1')
            ),
            'attributes' => array(
                'id' => 'filename',
            ),

        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'start' => array(
                'required' => true
            ),
            'finish' => array(
                'required' => true
            ),
            'device' => array(
                'required' => false
            ),
            'filename' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\Size',
                        'options' => array(
                            'min' => 120,
                            'max' => 200000,
                        ),
                    ),
                    array(
                        'name' => 'Zend\Validator\File\Extension',
                        'options' => array(
                            'extension' => 'gpx',
                        ),
                    ),
                    // Validate file with a GPX Schema
                    array(
                        'name' => 'Maps\Validator\File\IsGpx'
                    )
                ),
            ),
        );
    }

}
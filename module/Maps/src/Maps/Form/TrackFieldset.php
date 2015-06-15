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
            'type' => 'Zend\Form\Element\Text',
            'name' => 'start',
            'options' => array(
                'label' => 'Start',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'finish',
            'options' => array(
                'label' => 'Finish',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'device',
            'options' => array(
                'label' => 'Device',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'filename',
            'options' => array(
                'label'            => 'File',
            ),
            'attributes' => array(
                'id' => 'filename',
            ),

        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
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
                'allow_empty' => false,
                'type' => 'Zend\InputFilter\FileInput',
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\Size',
                        'options' => array(
                            //'min' => 120,
                            'max' => 600000,
                        ),
                        'break_chain_on_failure' => true,
                    ),
                    array(
                        'name' => 'Zend\Validator\File\Extension',
                        'options' => array(
                            'extension' => 'gpx',
                        ),
                        'break_chain_on_failure' => true,
                    ),
                    // Validate file with a GPX Schema
                    array(
                        'name' => 'Maps\Validator\File\IsGpx',
                        'break_chain_on_failure' => true,
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
            ),
        );
    }

}
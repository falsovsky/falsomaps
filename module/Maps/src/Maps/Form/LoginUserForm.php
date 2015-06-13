<?php

namespace Maps\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;


class LoginUserForm extends Form implements InputFilterProviderInterface
{

    public function __construct()
    {
        parent::__construct('login-user');

        $this->add(array(
            'name' => 'username',

            'attributes' => array(
                'autofocus'   => true,
                'placeholder' => 'username',
                'type'        => 'text'
            ),

            'options' => array(
                'label'            => 'Username',
                'column-size'      => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2'),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',

            'attributes' => array(
                'placeholder' => 'password',
                'type'        => 'password',
            ),

            'options' => array(
                'label'            => 'Password',
                'column-size'      => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2')
            ),
            
        ));

        $this->add(array(
            'name' => 'hash',
            'type' => 'csrf',
            'attributes' => array(
                'id' => 'csrf',
            ),
        ));

        $this->add(array(
            'name'       => 'button-submit',
            'type'       => 'button',
            'attributes' => array('type' => 'submit'),
            'options'    => array(
                'label' => 'Submit',
                'column-size' => 'sm-10 col-sm-offset-1',
            )
        ));
        
        //$this->setInputFilter($this->_getInputFilters());
    }

    public function getInputFilterSpecification()
    {
        return array(
            'username' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 25
                        )
                    )
                )
            ),

            'password' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 255
                        )
                    )
                )
            )
        );
    }

}


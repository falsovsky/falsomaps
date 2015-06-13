<?php
namespace Maps\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\JsonModel;
use Zend\InputFilter\Factory;

use Maps\Form\LoginUserForm;
use Maps\Entity\User;


class UserController extends AbstractActionController
{

    public function loginAction()
    {
        $this->setPageTitle("Login");

        $error = false;
        $form = new LoginUserForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                
                if ($this->_login($this->request->getPost('username'), $this->request->getPost('password')))
                {
                    return $this->redirect()->toRoute('home');
                } else {
                    $error = "Invalid username or password";
                }
            }
        }

        $viewModel = new ViewModel();

        return $viewModel->setVariables(
            array(
                'form' => $form,
                'error' => $error,
            )
        );
    }

    public function loginAjaxAction()
    {
        $result = array(
            'status' => 0,
        );

        $factory = new Factory();
        $inputFilter = $factory->createInputFilter(array(
            'username' => array(
                'name'       => 'username',
                'required'   => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 3
                        ),
                    ),
                ),
            ),
            'password' => array(
                'name'       => 'password',
                'required'   => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 4
                        ),
                    ),
                ),
            ),
        ));

        if ($this->request->isPost())
        {
            $inputFilter->setData($this->request->getPost());
            if ($inputFilter->isValid() == true)
            {
                if ($this->_login($this->request->getPost('username'), $this->request->getPost('password')))
                {
                    $result['status'] = 1;
                } else {
                    $result['message'][] = "Invalid username or password";
                }
            } else {
                $errorMessages = $inputFilter->getMessages();
                foreach($errorMessages as $k => $v)
                {
                    $result['message'][] = $k . ": " . array_shift($v);
                }

            }

        } else {
            $result['message'][] = "Nothing submited";
        }

        return new JsonModel($result);
    }

    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();
        return $this->redirect()->toRoute('home');
    }

    protected function _login($username, $password)
    {
        $status = false;

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();

        $adapter->setIdentityValue($username);
        $adapter->setCredentialValue($password);

        $authenticationResult = $authService->authenticate($adapter);

        if ($authenticationResult->isValid()) {
            $identity = $authenticationResult->getIdentity();
            $authService->getStorage()->write($identity);

            $status = true;
        }

        return $status;
    }

}

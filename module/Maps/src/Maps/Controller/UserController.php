<?php
namespace Maps\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

use Maps\Form\LoginUserForm;
use Maps\Entity\User;


class UserController extends AbstractActionController
{

    public function loginAction()
    {
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

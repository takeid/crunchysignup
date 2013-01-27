<?php

namespace CrunchySignup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use CrunchySignup\Entity\User as SignupModel;

class RegisterController extends AbstractActionController
{
    protected $crunchySignupService;
    
    public function registerAction()
    {
        // get service
        $service = $this->getCrunchySignupService();
        // get events manager
        $events = $this->getServiceLocator()->get('SharedEventManager');
        
        // Listen for registration process and fill crunchy module
        // specific fields
        $events->attach('ZfcUser\Service\User', 'register', function($e)  {
            // define current date
            $now = date('Y-m-d H:i:s');
            
            // get user module and write own fields
            $user = $e->getParam('user');
            
            // set crunchysignup specific fields in user db table
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);
            $user->setTokenCreatedAt($now);
            $user->generateToken();
        });
        
        // a little magic ;) which works fantastic
        // remember that object is always passed as reference
        $transport = new \stdClass();
        
        // Listen for registration completion and send an email after this operation   
        $events->attach('ZfcUser\Service\User', 'register.post', function($e) use($service, $transport)  {
            // get user model
            $user = $e->getParam('user');
            
            // set uesr object for future operations 
            $transport->user = $user;
            // send verification email
            $service->sendVerificationEmailMessage($user);
        });        

        // Hook into existing form processing logic
        $vm = $this->forward()->dispatch('zfcuser', array('action' => 'register'));

        // analyze response uri
        if($vm instanceof Response) {
            // set uris
            $zfcUserAction = $this->url()->fromRoute('zfcuser/register');
            $emailVerRoute = $this->url()->fromRoute('zfcuser/register/confirm-email');
            $zfcLogin = $this->url()->fromRoute('zfcuser/login');

            // get headers to analyze
            $allHeaders = $this->getResponse()->getHeaders();
            // get location from headers
            $locationHeader = $allHeaders->get('Location');
            if ( $locationHeader->getUri() == $zfcUserAction ) { // if register - set to $emailVerificationRoute
                $locationHeader->setUri($emailVerRoute);
            } else if ($locationHeader->getUri() == $zfcLogin) {             
                // show information that e-mail has been just sent to user
                $allHeaders->clearHeaders();
                $vm = new ViewModel(array(
                    'record' => $transport->user    
                ));
                $vm->setTemplate('crunchy-signup/register/email-confirmation');
                return $vm;
            }
            return $vm;            
        }

        // Set our own view script
        $vm->setTemplate('crunchy-signup/register/register');
        
        return $vm;
    }  
    
    public function checkTokenAction()
    {
        $service = $this->getCrunchySignupService();

        // remove old, not verified records 
        $service->cleanExpiredVerificationRequests();

        // Pull and validate the Request Key
        $token = $this->plugin('params')->fromRoute('token');
        $validator = new \Zend\Validator\Hex();
        if ( !$validator->isValid($token) ) {
            throw new \InvalidArgumentException('Invalid Token!');
        }
 
        // Find the token in DB
        $model = $service->findByToken($token);
        if ( ! $model instanceof SignupModel ) {
            throw new \InvalidArgumentException('Invalid Token!');
        }

        // activate user
        $service->activateUser($model);
        
        // get flash message after verification
        $message = $service->getEmailMessageOptions()->getFlashMessageAfterVerification();
        $this->flashMessenger()->addMessage($message);
        return $this->redirect()->toRoute('zfcuser/login');
    } 
    
    public function getCrunchySignupService()
    {
        if ($this->crunchySignupService === null)
        {
            $this->crunchySignupService = $this->getServiceLocator()->get('crunchysignup_ev_service');
        }
        return $this->crunchySignupService;            
    }
    
}
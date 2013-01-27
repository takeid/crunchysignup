<?php

namespace CrunchySignup\Service;

use ZfcBase\EventManager\EventProvider;
use CrunchySignup\Entity\User as Model;
use CrunchySignup\Mapper\Signup\MapperInterface as SignupMapper;
use Zend\Mail\Message as EmailMessage;
use Zend\Mail\Transport\TransportInterface as EmailTransport;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface as ViewRenderer;
use Zend\ServiceManager\ServiceLocatorInterface;

class Signup extends EventProvider
{
    /**
     * @var SignupMapper
     */
    protected $signupMapper;
    protected $serviceLocator;
    protected $emailMessageOptions;
    protected $emailRenderer;
    protected $emailTransport;
    protected $locator;

    public function findByToken($token)
    {
        return $this->getSignupMapper()->findByToken($token);
    }
    
    public function activateUser(Model $model)
    {
        $model->setState(1);
        $model->setToken(null);
        $model->setTokenCreatedAt(null); 
        $model->setUpdatedAt(date('Y-m-d H:i:s'));
       return $this->getSignupMapper()->update($model);
    }

    public function cleanExpiredVerificationRequests()
    {
        return $this->getSignupMapper()->cleanExpiredVerificationRequests();
    }

    public function sendVerificationEmailMessage(Model $record)
    {
        $fromAddress = $this->getEmailMessageOptions()->getEmailFromAddress();
        $subject = $this->getEmailMessageOptions()->getVerificationEmailSubjectLine();

        $message = new EmailMessage();
        $message->setFrom($fromAddress);
        $message->setTo($record->getEmail());
        $message->setSubject($subject);

        $viewModel = new ViewModel(array('record' => $record));
        $viewModel->setTerminal(true)->setTemplate('crunchy-signup/register/email/verification');
        $message->setBody($this->emailRenderer->render($viewModel));

        $this->emailTransport->send($message);
    }  

    /**
     * setEmailVerificationMapper
     *
     * @param SignupMapper $signupMapper
     * @return User
     */
    public function setSignupMapper(SignupMapper $signupMapper)
    {
        $this->signupMapper = $signupMapper;
        return $this;
    }

    public function getSignupMapper()
    {
        return $this->signupMapper;
    }

    public function setMessageRenderer(ViewRenderer $emailRenderer)
    {
        $this->emailRenderer = $emailRenderer;
        return $this;
    }

    public function setMessageTransport(EmailTransport $emailTransport)
    {
        $this->emailTransport = $emailTransport;
        return $this;
    }

    public function getEmailMessageOptions()
    {
        return $this->emailMessageOptions;
    }

    public function setEmailMessageOptions($opt)
    {
        $this->emailMessageOptions = $opt;
        return $this;
    }

    public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->locator = $sl;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->locator;
    }
}

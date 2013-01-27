<?php
namespace CrunchySignup\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    // you can set defaults here
    // can be overriden by config file under /config/autoload
    protected $storageAdapter = 'ZendDb';
    protected $emailFromAddress = '';
    protected $verificationEmailSubjectLine = 'Email Address Verification';
    protected $flashMessageAfterVerification = 'You are fully-registered, you can login now.';

    public function setStorageAdapter($adapter)
    {
        $this->storageAdapter = $adapter;
        return $this;
    }

    public function getStorageAdapter()
    {
        return $this->storageAdapter;
    }

    public function setEmailFromAddress($email)
    {
        $this->emailFromAddress = $email;
        return $this;
    }

    public function getEmailFromAddress()
    {
        return $this->emailFromAddress;
    }

    public function setVerificationEmailSubjectLine($subject)
    {
        $this->verificationEmailSubjectLine = $subject;
        return $this;
    }

    public function getVerificationEmailSubjectLine()
    {
        return $this->verificationEmailSubjectLine;
    }
    
    public function getFlashMessageAfterVerification()
    {
        return $this->flashMessageAfterVerification;
    }
    
    public function setFlashMessageAfterVerification($option)
    {
        $this->flashMessageAfterVerification = $option;
        return $this;
    }    
}

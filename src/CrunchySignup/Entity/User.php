<?php

namespace CrunchySignup\Entity;
use ZfcUser\Entity\User as ZfcUserEntity;

class User extends ZfcUserEntity
{    
    /**
     * @var datetime
     */
    protected $createdAt;
    
    /**
     * @var datetime
     */
    protected $updatedAt;
    
    /**
     * @var string
     */
    protected $token;
    
    /**
     * @var datetime
     */
    protected $tokenCreatedAt;
    
    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set createdAt
     * 
     * @param string $datetime
     * @return \CrunchySignup\Entity\User
     */
    public function setCreatedAt($datetime) {
        $this->createdAt = $datetime;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set updatedAt
     * 
     * @param string $datetime
     * @return \CrunchySignup\Entity\User
     */    
    public function setUpdatedAt($datetime) {
        $this->updatedAt = $datetime;
        return $this;
    }    
    
    public function getToken()
    {
        return $this->token;
    }
    
    public function setToken($token) 
    {
        $this->token = $token;
        return $this;
    }
    
    public function getTokenCreatedAt()
    {
        return $this->tokenCreatedAt;
    }
    
    public function setTokenCreatedAt($time) 
    {
        $this->tokenCreatedAt = $time;
        return $this;
    }
    
    public function generateToken()
    {
        $this->setToken(strtoupper(substr(sha1(
            $this->getEmail() . 
            '0#c#n#c#r#u0#y#h7' . 
            strtotime($this->getTokenCreatedAt())
        ),0,15)));
    }    
}

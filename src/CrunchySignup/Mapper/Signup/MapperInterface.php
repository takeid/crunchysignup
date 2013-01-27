<?php
namespace CrunchySignup\Mapper\Signup;

interface MapperInterface
{
    public function findByToken($key);

    public function cleanExpiredVerificationRequests($expiryTime=86400);
    
}

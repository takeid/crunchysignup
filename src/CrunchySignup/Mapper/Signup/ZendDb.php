<?php
namespace CrunchySignup\Mapper\Signup;

use ZfcBase\Mapper\AbstractDbMapper;

class ZendDb extends AbstractDbMapper implements MapperInterface
{
    protected $tableName = 'user';

    public function findByToken($key)
    {
        $select = $this->getSelect($this->tableName)->where(array('token' => $key));
        return $this->select($select)->current();
    }

    public function cleanExpiredVerificationRequests($expiryTime = 86400)
    {
        $delete = $this->delete(function($where) use ($expiryTime) {
            $now = new \DateTime((int)$expiryTime . ' seconds ago');
            $where->lessThanOrEqualTo('token_created_at', $now->format('Y-m-d H:i:s'));  
            // AND is used by default
            $where->literal('state != ?', 1);
        });
        
        return $delete->count();
    }
    
    public function update($model) {        
        $result = parent::update($model, array('user_id' => $model->getId()));
        return $result;
    }
}

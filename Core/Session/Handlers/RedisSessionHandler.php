<?php
namespace Core\Session\Handlers;

/**
* Session handler using Redis mechanism.
*/
class RedisSessionHandler implements \SessionHandlerInterface
{
    /**
    * @var int
    */
    public $expire = 1800; // 30 minutes default

    /**
    * @var string
    */
    public $prefix = 'PHPSESSID:';

    /**
    * @var object \PredisClient
    */
    protected $db;

    /**
    * @param object \PredisClient
    * @param string
    */
    public function __construct(PredisClient $db) 
    {
        $this->db = $db;
    }
 
    public function open($savePath, $sessionName) 
    {
        // No action necessary because connection is injected
        // in constructor and arguments are not applicable.
    }
 
    public function close() 
    {
        $this->db = null;
        unset($this->db);
    }
 
    public function read($id) 
    {
        $id = $this->prefix.$id;
        $sessData = $this->db->get($id);
        $this->db->expire($id, $this->expire);
        return $sessData;
    }
 
    public function write($id, $data) 
    {
        $id = $this->prefix.$id;
        $this->db->set($id, $data);
        $this->db->expire($id, $this->expire);
    }
 
    public function destroy($id) 
    {
        $this->db->del($this->prefix.$id);
    }
 
    public function gc($maxLifetime) 
    {
        // no action necessary because using EXPIRE
    }
}
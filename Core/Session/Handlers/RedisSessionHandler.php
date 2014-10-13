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
    public $expire = 7200;

    /**
    * @var string
    */
    public $prefix = 'PHPSESSID:';

    /**
    * @var object \Predis\Client
    */
    protected $db;

    /**
    * @param object \Predis\Client
    * @param string
    */
    public function __construct(\Predis\Client $db) 
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
        // No action necessary because using expire Redis option.
    }
}
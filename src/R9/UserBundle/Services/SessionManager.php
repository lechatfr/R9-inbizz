<?php

// \src\R9\UserBundle\Services\SessionManager.php

namespace R9\UserBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{
    private $session;
    
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    
    public function setData($cle, $data)
    {
        $this->session->set($cle, $data);
    }

    public function getData($cle)
    {
        return $this->session->get($cle);
    }

}
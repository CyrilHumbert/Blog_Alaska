<?php

namespace Blog_Alaska\model;

require_once("model/Manager.php");

class LoginManager extends Manager 
{
    public function login() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM logadmin');
        $reqs = $req->fetch();
        
        return $reqs;
    }

    public function verifSession() {

    }
}
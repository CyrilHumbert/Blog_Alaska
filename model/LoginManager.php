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

    public function getInfoSession() {
        $req = $this->sqlquery('SELECT id, pseudo, passwordde FROM logadmin WHERE id = ' . intval($_SESSION['admin_id']), 1);

        return $req;
    }

    public function getInfoCookie() {
        $req = $this->sqlquery('SELECT id, pseudo, passwordde FROM logadmin WHERE id = ' . intval($_COOKIE['admin_id']), 1);

        return $req;
    }
}
<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class AdminManager extends Manager
{
    public function listPostsAdmin() 
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, author, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date');

        return $req;
    }

    public function insertPostAdmin($title, $content, $author)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, author, creation_date) VALUE (?, ?, ?, NOW())');
        $reqs = $req->execute(array($title, $content, $author));

        return $reqs;
    }

    public function getInfoSession()
    {
        $req = $this->sqlquery('SELECT id, pseudo, passwordde FROM logadmin WHERE id = ' . intval($_SESSION['admin_id']), 1);

        return $req;
    }

    public function getInfoCookie()
    {
        $req = $this->sqlquery('SELECT id, pseudo, passwordde FROM logadmin WHERE id = ' . intval($_COOKIE['admin_id']), 1);

        return $req;
    }

    public function empty_cookie()
    {
        foreach($_COOKIE as $key => $element)
        {
            setcookie($key, '', time()-3600);
        }
    }
}
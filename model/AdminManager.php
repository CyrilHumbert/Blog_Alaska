<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class AdminManager extends Manager
{
    public function listPostsAdmin() 
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date');

        return $req;
    }

    public function insertPostAdmin($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date) VALUE (?, ?, NOW())');
        $reqs = $req->execute(array($title, $content));

        return $reqs;
    }
}
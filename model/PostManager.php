<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class PostManager extends Manager
{
    public function getPosts() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, author, content, DATE_FORMAT(creation_date, \'%d-%m-%Y\') AS creation_date_fr FROM posts WHERE status_post = 0 ORDER BY creation_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function getPost($postId) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, author, content, DATE_FORMAT(creation_date, \'%d-%m-%Y\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }
}
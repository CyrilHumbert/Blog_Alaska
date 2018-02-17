<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class AdminManager extends Manager
{
    public function updateChapter($postTitle, $postAuthor, $postContent, $getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET title = ?, author = ?, content = ?, comment_date = NOW() WHERE id = ?');
        $req->execute(array($postTitle, $postAuthor, $postContent, $getId));
    }

    public function listPostsAdmin() 
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, author, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC');
        $reqs = $req->fetchAll();

        return $reqs;
    }

    public function getChapterModif($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, author FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function insertPostAdmin($title, $content, $author)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, author, creation_date) VALUE (?, ?, ?, NOW())');
        $reqs = $req->execute(array($title, $content, $author));

        return $reqs;
    }
}
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
        $req = $db->query('SELECT id, title, nb_views, content, author, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

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

    /**** GESTION DES IP ET COMPTEUR DE VUE ****/

    public function getCheckIp($ip, $idChapter) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT ip FROM data_visiter WHERE ip = ? AND id_chapter = ?');
        $req->execute(array($ip, $idChapter));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function insertIp($ip, $idChapter) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO data_visiter(ip, date_visite, id_chapter) VALUE (?, NOW(), ?)');
        $req->execute(array($ip, $idChapter));
    }

    public function incrementView($idChapter) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET nb_views = nb_views + 1 WHERE id = ?');
        $req->execute(array($idChapter));
    }

}
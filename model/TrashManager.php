<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class TrashManager extends Manager
{
    public function listPostsTrash()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, id_chapter, title, content, author, creation_date FROM trash ORDER BY creation_date DESC');

        return $req;
    }

    /***** Insert into trash *****/

    public function selectChapterFromPosts($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, author, creation_date FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function insertChapterInTrash($postId, $title, $author, $content, $creationDate)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO trash(id_chapter, title, author, content, creation_date) VALUE (?, ?, ?, ?, ?)');
        $req->execute(array($postId, $title, $author, $content, $creationDate));
    }

    public function verifChapterSinceTrash($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_chapter FROM trash WHERE id_chapter = ?');
        $req->execute(array($postId));

        return $req;
    }

    public function deleteChapterFromPosts($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE id = ?');
        $req->execute(array($postId));
    }

    /***** End of insert into trash *****/

    /***** Insert into posts *****/

    public function selectChapterFromTrash($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, id_chapter, title, content, author, creation_date FROM trash WHERE id_chapter = ?');
        $req->execute(array($idChapter));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function insertChapterInPosts($idChapter, $title, $author, $content, $creationDate)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(id, title, author, content, creation_date) VALUE (?, ?, ?, ?, ?)');
        $req->execute(array($idChapter, $title, $author, $content, $creationDate));
    }

    public function verifChapterSincePosts($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM posts WHERE id = ?');
        $req->execute(array($idChapter));

        return $req;
    }

    public function deleteChapterFromTrash($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash WHERE id_chapter = ?');
        $req->execute(array($idChapter));
    }

    /***** End of insert into posts *****/

    public function deleteDefinitelySinceTrash($idChapterTrash)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash WHERE id = ?');
        $req->execute(array($idChapterTrash));
    }
}
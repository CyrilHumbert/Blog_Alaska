<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class TrashManager extends Manager
{
    public function listPostsTrash()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM trash ORDER BY creation_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function listCommentsTrash()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, id_before_delete, post_id, author, comment, comment_signal, have_response, comment_response, id_comment, delete_manual, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM trash_comment ORDER BY comment_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    /***** Insert into trash *****/

    public function selectChapterFromPosts($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function selectCommentFromComments($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM comments WHERE post_id = ?');
        $req->execute(array($postId));
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);
        
        return $reqs;
    }

    public function insertChapterInTrash($postId, $title, $nb_views, $author, $content, $creationDate, $status)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO trash(id_chapter, title, nb_views, author, content, creation_date, status_post) VALUE (?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($postId, $title, $nb_views, $author, $content, $creationDate, $status));
    }

    public function insertCommentInTrashComment($idBeforeDelete, $postIdComment, $author, $comment, $commentDate, $commentSignal, $haveResponse, $commentResponse, $idComment, $deleteManual)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO trash_comment(id_before_delete, post_id, author, comment, comment_date, comment_signal, have_response, comment_response, id_comment, delete_manual) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($idBeforeDelete, $postIdComment, $author, $comment, $commentDate, $commentSignal, $haveResponse, $commentResponse, $idComment, $deleteManual));
    }

    public function verifChapterSinceTrash($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM trash WHERE id_chapter = ?');
        $req->execute(array($postId));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function verifCommentSinceTrashComments($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM trash_comment WHERE post_id = ?');
        $req->execute(array($postId));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function deleteChapterFromPosts($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE id = ?');
        $req->execute(array($postId));
    }

    public function deleteCommentFromComments($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE post_id = ?');
        $req->execute(array($postId));
    }

    /***** End of insert into trash *****/

    /***** Insert into posts *****/

    public function selectChapterFromTrash($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM trash WHERE id_chapter = ?');
        $req->execute(array($idChapter));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function selectCommentFromTrashComments($idChapter){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM trash_comment WHERE post_id = ?');
        $req->execute(array($idChapter));
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function insertChapterInPosts($idChapter, $title, $nb_views, $author, $content, $creationDate, $status)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(id, title, nb_views, author, content, creation_date, status_post) VALUE (?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($idChapter, $title, $nb_views, $author, $content, $creationDate, $status));
    }

    public function insertCommentInComments($idBeforeDelete, $postIdComment, $author, $comment, $commentDate, $commentSignal, $haveResponse, $commentResponse, $idComment, $deleteManual)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(id, post_id, author, comment, comment_date, comment_signal, have_response, comment_response, id_comment, delete_manual) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($idBeforeDelete, $postIdComment, $author, $comment, $commentDate, $commentSignal, $haveResponse, $commentResponse, $idComment, $deleteManual));
    }

    public function verifChapterSincePosts($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM posts WHERE id = ?');
        $req->execute(array($idChapter));
        $reqs = $req->fetchAll();

        return $reqs;
    }

    public function verifCommentSinceComments($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM comments WHERE post_id = ?');
        $req->execute(array($idChapter));
        $reqs = $req->fetchAll();

        return $reqs;
    }

    public function deleteChapterFromTrash($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash WHERE id_chapter = ?');
        $req->execute(array($idChapter));
    }

    public function deleteCommentFromTrashComments($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash_comment WHERE post_id = ?');
        $req->execute(array($idChapter));
    }

    /***** End of insert into posts *****/

    public function deleteDefinitelySinceTrash($idChapterTrash)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash WHERE id = ?');
        $req->execute(array($idChapterTrash));
    }

    public function deleteDefinitelyComment($idChapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM trash_comment WHERE post_id = ?');
        $req->execute(array($idChapter));
    }
}
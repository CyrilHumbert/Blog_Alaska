<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
    /**** GESTION COMMENTAIRE QUI NE SONT PAS DES REPONSES ****/
    
    public function getComments($postId) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, author, comment, have_response, comment_response, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE post_id = ? AND comment_response = 0 ORDER BY comment_date DESC');
        $req->execute(array($postId));
        $comments = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $comments;
    }

    public function postComment($postId, $author, $comment) {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

    /**** GESTION DES COMMENTAIRES QUI SONT DES REPONSES ****/

    public function getCommentsResponse($idChapter) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, author, comment, id_comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE comment_response = 1 AND post_id = ? ORDER BY comment_date DESC');
        $req->execute(array($idChapter));
        $commentsResponse = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $commentsResponse;
    }

    public function postCommentResponse($postId, $author, $comment, $idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date, comment_response, id_comment) VALUES(?, ?, ?, NOW(), 1, ?)');
        $req->execute(array($postId, $author, $comment, $idComment));
    }

    public function updateCommentHaveResponse($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET have_response = 1 WHERE id = ?');
        $req->execute(array($idComment));
    }

    /**** SIGALEMENT COMMENTAIRE ****/

    public function updateSignalComment($idComment) {
        $db = $this->dbConnect();
        $comment = $db->prepare('UPDATE comments SET comment_signal = 1 WHERE id = ?');
        $comment->execute(array($idComment));
    }
}
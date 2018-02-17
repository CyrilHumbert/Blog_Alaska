<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $req->execute(array($postId));
        $comments = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

    public function viewModifComment($commentId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id = ?');
        $comments->execute(array($commentId));
        $modifComment = $comments->fetch();

        return $modifComment;
    }

    public function modifComment($author, $comment, $commentId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('UPDATE comments SET author = ?, comment = ?, comment_date = NOW() WHERE id = ?');
        $affectedComment = $comments->execute(array($author, $comment, $commentId));

        return $affectedComment;    
    }
}
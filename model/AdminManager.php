<?php
namespace Blog_Alaska\model;

require_once("model/Manager.php");

class AdminManager extends Manager
{
    public function updateChapter($postTitle, $postAuthor, $postContent, $status, $getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET title = ?, author = ?, content = ?, status_post = ? WHERE id = ?');
        $req->execute(array($postTitle, $postAuthor, $postContent, $status, $getId));
    }

    public function listPostsAdmin() 
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, nb_views, content, author, status_post, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function getChapterModif($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, author, status_post FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function insertPostAdmin($title, $content, $author, $status)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, author, creation_date, status_post) VALUE (?, ?, ?, NOW(), ?)');
        $reqs = $req->execute(array($title, $content, $author, $status));

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

    /**** GESTION COMMENTAIRES PAR L'ADMIN ****/


    /** COMMENTAIRE SIGNALES **/

    public function getCommentSignal() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, post_id, author, comment, comment_signal, have_response, comment_response, id_comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE comment_signal = 1 ORDER BY comment_date DESC');
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function modereAndUnsignalComment($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET comment = "Ce commentaire à été modéré car il contenait des propos diffamatoires, injurieux ou illégaux - Jean Forteroche", comment_signal = 0 WHERE id = ?');
        $req->execute(array($idComment));
    }

    public function deleteSignalComment($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $req->execute(array($idComment));
    }

    public function deleteResponseLinkAsSignal($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id_comment = ?');
        $req->execute(array($idComment));
    }

    public function unsignalComment($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET comment_signal = 0 WHERE id = ?');
        $req->execute(array($idComment));
    }

    /** SUPPRESSION DE COMMENTAIRE MANUEL **/

    public function selectCommentForManualDelete($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM comments WHERE id = ?');
        $req->execute(array($idComment));
        $reqs = $req->fetch(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function selectCommentResponseManualDelete($idComment) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM comments WHERE comment_response = 1 AND id_comment = ?');
        $req->execute(array($idComment));
        $reqs = $req->fetchAll(\PDO::FETCH_ASSOC);

        return $reqs;
    }

    public function verifCommentForManualDelete($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM trash_comment WHERE id_before_delete = ?');
        $req->execute(array($idComment));
        $reqs = $req->fetch();

        return $reqs;
    }

    public function deleteCommentForManualDelete($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $req->execute(array($idComment));
    }
}
<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

use Blog_Alaska\model\PostManager as PostManager;
use Blog_Alaska\model\CommentManager as CommentManager;

/**** VIEW ****/

function loginView() {
    require('view/frontend/loginAdminView.php');
}

function listPosts() {
    $postManager = new PostManager;
    $posts = $postManager->getPosts();

    require('view/frontend/listPostsView.php');
}

function post($chapterId) {
    $postManager = new PostManager;
    $commentManager = new CommentManager;

    $post = $postManager->getPost($chapterId);
    $comments = $commentManager->getComments($chapterId);
    $commentsResponse = $commentManager->getCommentsResponse($chapterId);

    require('view/frontend/postView.php');
}

/**** GESTION DES COMMENTAIRES ****/

function addComment($postId, $author, $comment) {
    $commentManager = new CommentManager;

	$secret = "6Lcj60wUAAAAAPTStOjukTF_1H0p7hgqsdbpM40W";

	$response = $_POST['g-recaptcha-response'];

	$remoteip = $_SERVER['REMOTE_ADDR'];
	
	$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
	    . $secret
	    . "&response=" . $response
	    . "&remoteip=" . $remoteip ;
	
	$decode = json_decode(file_get_contents($api_url), true);
	
	if ($decode['success'] == true) {
        $postAuthor = trim($author);
        $postComment = trim($comment);

        if (!empty($postAuthor) && !empty($postComment)) {
            $affectedLines = $commentManager->postComment($postId, htmlspecialchars($postAuthor), htmlspecialchars($postComment));

            if ($affectedLines === false) {
                throw new Exception('Impossible d\'ajouter le commentaire !');
            }
            else {
                header('Location: index.php?action=chapter&id=' . $postId);
                exit();
            }
        }
        else {
            throw new Exception('Tous les champs ne sont pas remplis !');
        }        
	}	
	else {
        throw new Exception('Captcha invalide !');
	}
}

function addCommentResponse($postId, $author, $comment, $idComment) {
    $commentManager = new CommentManager;

    $secret = "6Lcj60wUAAAAAPTStOjukTF_1H0p7hgqsdbpM40W";

	$response = $_POST['g-recaptcha-response'];

	$remoteip = $_SERVER['REMOTE_ADDR'];
	
	$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
	    . $secret
	    . "&response=" . $response
	    . "&remoteip=" . $remoteip ;
	
    $decode = json_decode(file_get_contents($api_url), true);
    
    if ($decode['success'] == true) {
        $postAuthorResponse = trim($author);
        $postCommentResponse = trim($comment);

        if (!empty($postAuthorResponse) && !empty($postCommentResponse)) {
            $addComment = $commentManager->postCommentResponse($postId, htmlspecialchars($postAuthorResponse), htmlspecialchars($postCommentResponse), $idComment);

            if ($addComment === false) {
                throw new Exception('Impossible d\'ajouter le commentaire !');
            }
            else {
                $commentManager->updateCommentHaveResponse($idComment);

                header('Location: index.php?action=chapter&id=' . $postId);
                exit();
            }
        }
        else {
            throw new Exception('Tous les champs ne sont pas remplis !');
        }    
    }      
    else {
        throw new Exception('Captcha invalide !');
    }
}

function signalComment($idComment) {
        $commentManager = new CommentManager;

        $commentManager->updateSignalComment($idComment);

        header('Location: index.php?action=chapter&id=' . $_GET['idp']);
        exit();
}

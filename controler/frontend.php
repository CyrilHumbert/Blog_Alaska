<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

use Blog_Alaska\model\PostManager as PostManager;
use Blog_Alaska\model\CommentManager as CommentManager;

function loginView()
{
    require('view/frontend/loginAdminView.php');
}

function listPosts()
{
    $postManager = new PostManager; // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet

    require('view/frontend/listPostsView.php');
}

function post()
{
    $postManager = new PostManager;
    $commentManager = new CommentManager;

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new CommentManager;

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function viewModifComment()
{
    $commentManager = new CommentManager;

    $commentModifView = $commentManager->viewModifComment($_GET['id']);

    require('view/frontend/modifCommentView.php');
}

function rewordComment()
{
    $commentManager = new CommentManager;

    $affectedComment = $commentManager->modifComment($_POST['author'], $_POST['comment'], $_GET['id']);

    if($affectedComment === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else{
        header('Location: index.php?action=post&id=' . $_GET['idp']);
    }
}

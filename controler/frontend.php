<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function login()
{
    require('view/frontend/loginAdminView.php');
}

function listPosts()
{
    $postManager = new \cours\Tp_forum\model\PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet

    require('view/frontend/listPostsView.php');
}

function post()
{
    $postManager = new \cours\Tp_forum\model\PostManager();
    $commentManager = new \cours\Tp_forum\model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new \cours\Tp_forum\model\CommentManager();

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
    $commentManager = new \cours\Tp_forum\model\CommentManager();

    $commentModifView = $commentManager->viewModifComment($_GET['id']);

    require('view/frontend/modifCommentView.php');
}

function rewordComment()
{
    $commentManager = new \cours\Tp_forum\model\CommentManager();

    $affectedComment = $commentManager->modifComment($_POST['author'], $_POST['comment'], $_GET['id']);

    if($affectedComment === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else{
        header('Location: index.php?action=post&id=' . $_GET['idp']);
    }
}

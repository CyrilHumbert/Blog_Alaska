<?php
require('controler/frontend.php');
require('controler/backend.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'modifComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                    viewModifComment($_GET['id']);
                if ($_GET['action'] == 'modifComment') {
                    if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_POST['author']) && isset($_POST['comment'])) {
                        if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                            rewordComment();
                        }
                    }
                }
            }else {
                throw new Exception('Identifiant de billet incorrect');
            }
        }
        elseif ($_GET['action'] == 'login') {
            if (isset($_GET['postLogin']) &&  $_GET['postLogin'] == true) {
                verifLogin($_POST['pseudo'], $_POST['password']);
            }else {
                loginView();
            }
        }
    }else {
        listPosts();
    }
}
catch(Exception $e) {
    require "view/frontend/informations.php";
}
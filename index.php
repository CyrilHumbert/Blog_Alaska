<?php session_start(); ?>

<?php
require('controler/frontend.php');
require('controler/backend.php');

refresh_session();

try {
    //======================================================================
    // Vérification du paramètre action en GET
    //======================================================================
    if (isset($_GET['action'])) { 
        
        /* On affiche la liste des chapitres, référenciel page d'accueil */
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        /* Fin d'affichage liste chapitre */

        /* Affhichage d'un chapitre et ses commentaires */
        elseif ($_GET['action'] == 'chapter') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                checkVisite($_SERVER['REMOTE_ADDR'], $_GET['id']);
                post($_GET['id']);
            }else {
                throw new Exception('Aucun identifiant de chapitre envoyé');
            }
        }
        /* Fin d'affichage d'un chapitre */

        /* Signalement commentaire */
        elseif ($_GET['action'] == 'signal') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                signalComment($_GET['id']);
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }

        /* Ajout d'un commentaire lié à un chapitre */
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['response'])) {
                if (isset($_GET['idpost']) && $_GET['idpost'] > 0) {
                    if (isset($_GET['idcomment']) && $_GET['idcomment'] > 0) {
                        if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                            addCommentResponse($_GET['idpost'], $_POST['author'], $_POST['comment'], $_GET['idcomment']);
                        }
                        else {
                            throw new Exception('Tous les champs ne sont pas remplis !');
                        }
                    }
                    else {
                        throw new Exception('Identifiant du commentaire incorrect');
                    }
                }
                else {
                    throw new Exception('Identifiant du chapitre incorrect');
                }
            }
            elseif (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }else {
                throw new Exception('Aucun identifiant de chapitre envoyé');
            }
        }
        /* Fin d'ajout de commentaire */

        /* Modification d'un commentaire lié à un chapitre */
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
                throw new Exception('Identifiant de chapitre incorrect');
            }
        }
        /* Fin modification commentaire */

        /* Système de login */
        elseif ($_GET['action'] == 'login') { 
            if(isset($_SESSION['admin_id'])) {
                refresh_session();       // Si déjà connecté, redirige vers le pannel d'admin
                if(isset($_SESSION['connected'])) {
                    pannelAdminView();
                }else {
                    accessDenied();     // Si la session est invalide, erreur 403
                }
            }elseif(isset($_GET['postLogin'])) {
                verifLogin($_POST['pseudo'], $_POST['password']);
            }else {
                loginView();
            }    
        }
        /* Fin système login */

        /* Gestion de la déconnexion */
        elseif ($_GET['action'] == 'disconnect') {
            disconnect();
        }
        /* Fin déconnexion */

        /* Gestion de l'administration */
        elseif ($_GET['action'] == 'administration') { 
            if(isset($_SESSION['admin_id'])) {
                refresh_session();      // Vérification de la connexion 
                if(isset($_SESSION['connected'])) {

                    /* Gestion de l'éditeur */
                    if(isset($_GET['editer'])) { 
                        if(isset($_GET['post'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                chapterModif($_POST['title'], $_POST['author'], $_POST['content'], $_GET['id']);
                            }else {
                                addPostAdmin($_POST['title'], $_POST['content'], $_POST['author']);
                            }
                        }elseif(isset($_GET['id']) && $_GET['id'] > 0) {
                            editerModif($_GET['id']);
                        }else {
                            viewEditer();
                        }
                    }
                    /* Fin de l'éditeur */

                    /* Gestion de la mise en corbeille */
                    elseif(isset($_GET['delete'])) { // 
                        if(isset($_GET['id']) && $_GET['id'] > 0) {
                            chapterTrash($_GET['id']);
                        }else {
                            throw new Exception('Identifiant de chapitre incorrect');
                        }
                    }
                    /* Fin de la mise en corbeille */

                    /* Gestion de la corbeille (restauration, supression..) */
                    elseif(isset($_GET['trash'])) {
                        if(isset($_GET['restore'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                restoreTrash($_GET['id']);
                            }else {
                                throw new Exception('Identifiant de chapitre incorrect');
                            }
                        }elseif(isset($_GET['deletetrash'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                deleteDefinitely($_GET['id']);
                            }else {
                                throw new Exception('Identifiant de chapitre incorrect');  
                            }
                        }else {
                            viewTrash();
                        }
                    }
                    /* Fin de la gestion de la corbeille */
                    
                    /* Si aucune valeur, affiche le pannel admin */
                    else {
                        pannelAdminView();
                    }
            }else {
                throw new Exception('Session invalide, merci de vous reconnectez. <br> <a href="index.php"/>Cliquez ici pour revenir à l\'accueil...</a>'); // Connecté mais session invalide
            }            
        }else {
            accessDenied(); // Si on veut accèder à l'administration sans être connecté, erreur 403
        }
    }
    /* Fin de la gestion administration */

    }
    //======================================================================
    // Fin Vérification du paramètre action en GET
    //======================================================================

    /* Si aucune valeur, affiche la page d'accueil par défault */
    else {
        listPosts();
    }

} // Fin du try
catch(Exception $e) {
    require "view/frontend/informations.php";
}
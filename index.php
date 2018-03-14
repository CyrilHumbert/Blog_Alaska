<?php session_start(); ?>
<?php ob_start(); ?>

<?php
require('controler/frontend.php');
require('controler/backend.php');

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
                        if (!empty($_POST['authorResponse']) && !empty($_POST['commentResponse'])) {
                            addCommentResponse($_GET['idpost'], $_POST['authorResponse'], $_POST['commentResponse'], $_GET['idcomment']);
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
                                chapterModif($_POST['title'], $_POST['author'], $_POST['content'], $_POST['status'], $_GET['id']);
                            }else {
                                addPostAdmin($_POST['title'], $_POST['content'], $_POST['author'], $_POST['status']);
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
                            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                chapterTrash($_GET['id'], $_POST['token']);
                            }else {
                                throw new Exception('Action impossible, cet accès est protégé.');
                            }
                        }else {
                            throw new Exception('Identifiant de chapitre incorrect');
                        }
                    }
                    /* Fin de la mise en corbeille */

                    /* Gestion de la corbeille (restauration, supression..) */
                    elseif(isset($_GET['trash'])) {
                        if(isset($_GET['restore'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                    restoreTrash($_GET['id'], $_POST['token']);
                                }else {
                                    throw new Exception('Action impossible, cet accès est protégé.');
                                }
                            }else {
                                throw new Exception('Identifiant de chapitre incorrect');
                            }
                        }elseif(isset($_GET['deletetrash'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                    deleteDefinitely($_GET['id'], $_GET['idp'], $_POST['token']);
                                }else {
                                    throw new Exception('Action impossible, cet accès est protégé.');
                                }
                            }else {
                                throw new Exception('Identifiant de chapitre incorrect');  
                            }
                        }else {
                            viewTrash();
                        }
                    }
                    /* Fin de la gestion de la corbeille */
                    
                    /* Gestion des commentaires */
                    elseif (isset($_GET['comment'])) {
                        if(isset($_GET['modere'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                if(isset($_POST['choiceModere'])) {
                                    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                        modereComment($_GET['id'], $_POST['choiceModere'], $_POST['token']);
                                    }else {
                                        throw new Exception('Action impossible, cet accès est protégé.');
                                    }
                                }else {
                                    throw new Exception('Un choix doit être fait obligatoirement');
                                }
                            }else {
                                throw new Exception('Identifiant de commentaire incorrect');
                            }
                        }
                        if(isset($_GET['deletecomment'])) {
                            if(isset($_GET['signal'])) {
                                if(isset($_GET['id']) && $_GET['id'] > 0) {
                                    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                        deleteSignalComment($_GET['id'], $_GET['response'], $_GET['idc'], $_GET['commentresponse'], $_POST['token']);
                                    }else {
                                        throw new Exception('Action impossible, cet accès est protégé.');
                                    }
                                }else {
                                    throw new Exception('Identifiant de commentaire incorrect');
                                }
                            }
                            if(isset($_GET['manual'])) {
                                if(isset($_GET['id']) && $_GET['id'] > 0) {
                                    if(isset($_GET['idp']) && $_GET['idp'] > 0) {
                                        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                            deleteCommentManual($_GET['id'], $_GET['idp'], $_GET['idc'], $_POST['token']);
                                        }else {
                                            throw new Exception('Action impossible, cet accès est protégé.');
                                        }
                                    }else {
                                        throw new Exception('Identifiant de chapitre incorrect');
                                    }
                                }else {
                                    throw new Exception('Identifiant de commentaire incorrect');
                                }
                            }
                            if(isset($_GET['trashcomment'])) {
                                if(isset($_GET['id']) && $_GET['id'] > 0) {
                                    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                        deleteCommentFromTrash($_GET['id'], $_GET['idc'], $_POST['token']);
                                    }else {
                                        throw new Exception('Action impossible, cet accès est protégé.');
                                    }
                                }else {
                                    throw new Exception('Identifiant de commentaire incorrect');
                                }
                            }
                        }
                        if(isset($_GET['aprove'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                    aproveSignal($_GET['id'], $_POST['token']);
                                }else {
                                    throw new Exception('Action impossible, cet accès est protégé.');
                                }
                            }else {
                                throw new Exception('Identifiant de commentaire incorrect');
                            }
                        }
                        if(isset($_GET['restorecomment'])) {
                            if(isset($_GET['id']) && $_GET['id'] > 0) {
                                if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                    restoreCommentManual($_GET['id'], $_GET['idc'], $_POST['token']);
                                }else {
                                    throw new Exception('Action impossible, cet accès est protégé.');
                                }
                            }else {
                                    throw new Exception('Identifiant de commentaire incorrect');
                            }
                        }
                    }
                    /* Fin de la gestion des commentaires */

                    /* Gestion de la page config */
                    elseif(isset($_GET['config'])) {
                        if(isset($_GET['modifpseudo'])) {
                            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                modifPseudo($_POST['pseudoModif'], $_POST['token']);
                            }else {
                                throw new Exception('Action impossible, cet accès est protégé.');
                            }
                        }
                        elseif(isset($_GET['changepassword'])) {
                            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                modifPassword($_POST['ancienPassword'], $_POST['newPassword'], $_POST['confirmPassword'], $_POST['token']);
                            }else {
                                throw new Exception('Action impossible, cet accès est protégé.');
                            }
                        }elseif(isset($_GET['modifmodere'])) {
                            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
                                modifModere($_POST['choiceModere1'], $_POST['choiceModere2'], $_POST['choiceModere3'], $_POST['token']);
                            }else {
                                throw new Exception('Action impossible, cet accès est protégé.');
                            }
                        }else {
                            viewConfig();
                        }
                    }
                    /* Fin de la gestion page config */

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
    elseif($_SERVER['QUERY_STRING'] == '') {
        listPosts();
    } 
    else{
        header("HTTP/1.0 404 Not Found");
        
        require("view/frontend/error404.php");
    }

} // Fin du try
catch(Exception $e) {
    require("view/frontend/informations.php");
}
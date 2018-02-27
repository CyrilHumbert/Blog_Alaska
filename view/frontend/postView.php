<?php $title = htmlspecialchars($post['title']) . " - Blog Alaska"; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBan" class="row">
        <div class="btnRetourAccueil">
            <a href="index.php" class="btn linkRetourAccueil">Retour à l'accueil</a>
        </div>

        <div class="container-fluid" id="firstLine">
            <h1 id="titleChapter" class="text-center"><?= htmlspecialchars($post['title']) ?></h1>
        </div>
            
        <div class="container-fluid" id="secondeLine">
            <h3 id="dateChapter" class="text-center">le <?= htmlspecialchars($post['creation_date_fr']) ?></h3>
        </div>
    </header>
</div>

<div class="container" style="overflow-x: hidden;">
    <div class="chapter">    
        <div class="contentChapter">
            <p><?= $post['content'] ?></p>
        </div>
    </div>

    <h2 class="text-center">Commentaire</h2>

    <p class="text-center">
        <?= $countcomment = count($comments) + count($commentsResponse); ?> commentaire<?php if($countcomment > 1): ?>s<?php endif ?>
    </p>


    <!--- Modal d'ajout de commentaire -->
    <button class="btnAddComment btn center-block" href="#addComment" data-toggle="modal" data-backdrop="false">Ajouter un commentaire</button>
    <div class="modal fade modalAddCommenttest" id="addComment">
        <div class="modal-dialog modalAddComment">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title text-center">Ajouter votre commentaire</h4>
                </div>

                <div class="modal-body">
                    <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="POST">
                        <div class="form-group">
                            <label for="author">Pseudo</label><br>
                            <input type="text" name="author" id="author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment">Commentaire</label><br>
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
               </div>

                <div class="modal-footer">
                    <button class="btn btn-info pull-left" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-info pull-right">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--- Fin modal -->

    <!-- Début de l'affichage des commentaires -->
    <ul class="media-list">
        <?php foreach($comments as $row => $data): ?>
            <?php if($data['comment_response'] == false): ?>
                <li class="media thumbnail">
                    <div class="media-body"> 
                        <div class="row">
                            <div class="pull-left col-sm-6">
                                <p class="media-heading">Par <?= htmlspecialchars($data['author']) ?>
                                    <?php if(isset($_SESSION['admin_id'])): ?>
                                    | <a href="#infosDeleteComment<?= $data['id'] ?>" data-toggle="modal">Supprimer</a>
                                    <?php endif; ?>
                                    | <a data-toggle="modal" href="#formulaire<?= $data['id'] ?>" data-backdrop="false">Répondre</a> |
                                    <a href="#infosSignalComment<?= $data['id'] ?>" data-toggle="modal">Signaler</a> | 
                                </p>
                            </div> 

                            <div class="col-sm-6">
                                <p class="pull-right">Le <?= htmlspecialchars($data['comment_date_fr']) ?></p>
                            </div>
                        </div>

                        <div class="row"><p class="col-lg-12"><?= $data['comment'] ?></p></div>

                        <!-- Affichage des réponses à un commentaire -->
                        <?php if($data['have_response'] == true): ?>
                            <div class="media thumbnail body-response">
                                <?php foreach($commentsResponse as $rowResponse => $dataResponse): ?>
                                    <?php if($data['id'] == $dataResponse['id_comment']): ?>
                                        <div class="media responsePost">
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="pull-left col-sm-6">
                                                        <p class="media-heading">Par <?= htmlspecialchars($dataResponse['author']) ?> 
                                                        <?php if(isset($_SESSION['admin_id'])): ?>
                                                        | <a href="#infosDeleteComment<?= $dataResponse['id'] ?>" data-toggle="modal">Supprimer</a>
                                                        <?php endif; ?>
                                                        | <a href="#infosSignalComment<?= $dataResponse['id'] ?>" data-toggle="modal">Signaler</a> | 
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <p class="pull-right">Le <?= $dataResponse['comment_date_fr'] ?></p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"><p><?= htmlspecialchars($dataResponse['comment']) ?></p></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Début de la modal de signalement d'un commentaire qui est une réponse -->
                                    <div class="modal fade" id="infosSignalComment<?= $dataResponse['id'] ?>">
                                        <div class="modal-dialog modalRespon">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">x</button>
                                                    <h4 class="modal-title text-center">Confirmation</h4>
                                                </div>

                                                <div class="modal-body text-center">
                                                    Voulez-vous vraiment signaler ce commentaire ?<br>
                                                    Celui-ci sera remonté à l'administrateur pour être modérer.
                                                </div>

                                                <div class="modal-footer">
                                                    <a href="index.php?action=signal&amp;id=<?= $dataResponse['id'] ?>&amp;idp=<?= $_GET['id']?>" class="btn btn-info pull-left">Signaler</a>
                                                    <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin de la modal -->  
                                    <!-- Début de la modal de suppresion d'un commentaire qui est une réponse -->
                                    <div class="modal fade" id="infosDeleteComment<?= $dataResponse['id'] ?>">
                                        <div class="modal-dialog modalRespon">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">x</button>
                                                    <h4 class="modal-title text-center">Confirmation</h4>
                                                </div>

                                                <div class="modal-body text-center">
                                                    Voulez-vous vraiment supprimer ce commentaire ?<br>
                                                    Celui-ci sera placé dans la corbeille ainsi que les commentaires lié à celui-ci.
                                                </div>

                                                <div class="modal-footer">
                                                    <a href="index.php?action=administration&amp;comment&amp;deletecomment&amp;manual&amp;id=<?= $dataResponse['id'] ?>&amp;idp=<?= $_GET['id']?>&amp;idc=<?= $dataResponse['id_comment'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                                    <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin de la modal -->  
                                <?php endforeach; ?>  
                            </div>
                        <?php endif; ?>
                        <!-- Fin d'affichage réponse -->
                    </div>
                </li>
            <?php endif; ?>

            <!-- Début de la modal de suppresion d'un commentaire qui n'est pas une réponse -->
            <div class="modal fade" id="infosDeleteComment<?= $data['id'] ?>">
                <div class="modal-dialog modalRespon">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title text-center">Confirmation</h4>
                        </div>

                        <div class="modal-body text-center">
                            Voulez-vous vraiment supprimer ce commentaire ?<br>
                            Celui-ci sera placé dans la corbeille ainsi que les commentaires lié à celui-ci.
                        </div>

                        <div class="modal-footer">
                            <a href="index.php?action=administration&amp;comment&amp;deletecomment&amp;manual&amp;id=<?= $data['id'] ?>&amp;idp=<?= $_GET['id']?>&amp;idc=0" class="btn btn-info pull-left">Supprimer</a>
                            <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de la modal -->  

            <!-- Début de la modal de signalement d'un commentaire qui n'est pas une réponse -->
            <div class="modal fade" id="infosSignalComment<?= $data['id'] ?>">
                <div class="modal-dialog modalRespon">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title text-center">Confirmation</h4>
                        </div>

                        <div class="modal-body text-center">
                            Voulez-vous vraiment signaler ce commentaire ?<br>
                            Celui-ci sera remonté à l'administrateur pour être modérer.
                        </div>

                        <div class="modal-footer">
                            <a href="index.php?action=signal&amp;id=<?= $data['id'] ?>&amp;idp=<?= $_GET['id']?>" class="btn btn-info pull-left">Signaler</a>
                            <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de la modal -->  

            <!-- Début de la modal de l'ajout d'une réponse à un commentaire -->
            <div class="modal fade" id="formulaire<?= $data['id'] ?>">
                <div class="modal-dialog modalReponse">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title text-center">Ajouter votre commentaire</h4>
                        </div>

                        <div class="modal-body">
                            <form action="index.php?action=addComment&amp;response&amp;idpost=<?= $post['id'] ?>&amp;idcomment=<?= $data['id'] ?>" method="POST">
                                <div class="form-group">
                                    <label for="authorResponse">Pseudo</label>
                                    <input type="text" name="authorResponse" id="authorResponse" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="commentResponse">Commentaire</label>
                                    <textarea name="commentResponse" id="commentResponse" class="form-control"></textarea>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-info pull-left" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-info pull-right">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de la modal -->
        <?php endforeach; ?>
    </ul>
    <!-- Fin d'affichage des commentaires -->
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

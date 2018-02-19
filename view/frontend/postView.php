<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>

<header id="headerBan" class="row">
    <div class="container-fluid">
        <div class="row" id="firstLine">
            <h1 id="titleChapter" class="text-center"><?= htmlspecialchars($post['title']) ?></h1>
        </div>
        
        <div class="row" id="secondeLine">
            <h3 id="dateChapter" class="text-center">le <?= $post['creation_date_fr'] ?></h3>
        </div>
    </div> 
</header>

<div class="container">

    <p><a href="index.php">Retour à la liste des chapitres</a></p>

    <div class="chapter">    
        <div class="contentChapter">
            <?= $post['content'] ?>
        </div>
    </div>

    <h2 class="text-center">Commentaire</h2>

    <p class="text-center"><?= $countcomment = count($comments) + count($commentsResponse); ?> commentaire<?php if($countcomment > 1): ?>s<?php endif ?></p>


    <!--- Modal d'ajout de commentaire -->
    <button class="btnAddComment btn btn-primary center-block" href="#addComment" data-toggle="modal">Ajouter un commentaire</button>
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
                            <label for="author" class="labelPostAuthor">Pseudo</label>
                            <input type="text" class="inputPostAuthor" name="author" id="author">
                        </div>

                        <div class="form-group">
                            <label for="comment" class="labelPostComment">Commentaire</label>
                            <input type="text" class="inputPostComment" name="comment" id="comment">
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
                        <div class="pull-left">
                            <p class="media-heading">Par <?= htmlspecialchars($data['author']) ?> 
                            | <a href="index.php?action=modifComment&amp;id=<?= $data['id'] ?>&amp;idp=<?= $_GET['id']?>">Modifier</a> | 
                            <a data-toggle="modal" href="#formulaire<?= $data['id'] ?>">Répondre</a> |
                            <a href="index.php?action=signal&amp;id=<?= $data['id'] ?>&amp;idp=<?= $_GET['id']?>">Signaler</a> | 
                            </p>
                            <!-- Début de la modal de l'ajout d'une réponse à un commentaire -->
                            <div class="modal fade" id="formulaire<?= $data['id'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                            <h4 class="modal-title text-center">Ajouter votre commentaire</h4>
                                        </div>

                                        <div class="modal-body">
                                            <form action="index.php?action=addComment&amp;response&amp;idpost=<?= $post['id'] ?>&amp;idcomment=<?= $data['id'] ?>" method="POST">
                                                <div class="form-group">
                                                    <label for="author" class="labelPostAuthor">Pseudo</label>
                                                    <input type="text" class="inputPostAuthor" name="author" id="author">
                                                </div>

                                                <div class="form-group">
                                                    <label for="comment" class="labelPostComment">Commentaire</label>
                                                    <input type="text" class="inputPostComment" name="comment" id="comment">
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
                        </div> 

                        <div class="pull-right">
                            <p>Le <?= htmlspecialchars($data['comment_date_fr']) ?></p>
                        </div>

                        <div class="col-lg-12"><p><?= $data['comment'] ?></p></div>

                        <!-- Affichage des réponses à un commentaire -->
                        <?php if($data['have_response'] == true): ?>
                            <div class="media thumbnail body-response">
                                <?php foreach($commentsResponse as $rowResponse => $dataResponse): ?>
                                    <?php if($data['id'] == $dataResponse['id_comment']): ?>
                                            <div class="media responsePost">
                                            <div class="media-body">
                                            <div class="pull-left">
                                                <p class="media-heading">Par <?= htmlspecialchars($dataResponse['author']) ?> 
                                                | <a href="index.php?action=signal&amp;id=<?= $dataResponse['id'] ?>&amp;idp=<?= $_GET['id']?>">Signaler</a> | 
                                            </div>

                                            <div class="pull-right">
                                                <p>Le <?= $dataResponse['comment_date_fr'] ?></p>
                                            </div>

                                            <div class="col-lg-12"><p><?= htmlspecialchars($dataResponse['comment']) ?></p></div>
                                        </div>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>  
                            </div>
                        <?php endif; ?>
                        <!-- Fin d'affichage réponse -->
                    </div>
                </li>
            <?php endif; ?>    
        <?php endforeach; ?>
    </ul>
    <!-- Fin d'affichage des commentaires -->
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<?php $title = "Pannel d'administration - Editeur"; ?>

<?php ob_start(); ?>

    <div class="container">
        <form method="POST" action="index.php?action=administration&amp;editer&amp;post">
            <div class="row">
                <div class="divTitle form-group col-lg-9">
                    <label for="title" class="labelTitleEditor">Titre du chapitre</label>
                    <input type="text" name="title"  class="inputTitle "/>
                </div>

                <div class="divAuthor form-group col-lg-3">
                    <label for="author" class="labelAuthorEditor">Auteur</label>
                    <input type="text" name="author" class="inputAuthor form-control"/>
                </div>
            </div>

            <div class="form-group">
                <textarea id="editer" name="content"></textarea>
            </div>

            <div class="row rowButton">
                <?php if (isset($error)): ?>
                    <div class="alert alert-block alert-danger text-center col-sm-9">
                    Tous les champs doivent être remplis !
                    </div>
                <?php endif ?> 

                <button id="buttonEditor" name="button" class="btn btn-primary pull-right col-sm-2">Envoyer</button>
            </div>
        </form>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('templateEditor.php'); ?>
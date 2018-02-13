<?php $title = "Pannel d'administration - Editeur"; ?>

<?php ob_start(); ?>

<div class="row">
    <div class="container">
        <form method="POST" action="index.php?action=administration&amp;editer&amp;post">
            <div class="form-group text-center">
                <label for="title" class="labelTitleEditor">Titre du chapitre :</label>
                <input type="text" name="title"  class="form-control"/>
            </div>

            <div class="form-group">
                <textarea id="editor" name="content">Next, start a free trial!</textarea>
            </div>

            <?php if (isset($error)): ?>
            <div class="row">
                <div class="alert alert-block alert-danger text-center col-sm-9">
                Tous les champs doivent être remplis !
                </div>
            </div>
            <?php endif ?>  
            <button id="buttonEditor" name="button" class="btn btn-primary pull-right col-lg-2">Envoyer</button>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateEditor.php'); ?>
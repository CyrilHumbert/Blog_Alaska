<?php $title = "Pannel d'administration - Editeur"; ?>

<?php ob_start(); ?>

    <div class="container">
        <form method="POST" action="index.php?action=administration&amp;editer&amp;post">
            <div class="row">
                <div class="divEditer form-group col-lg-9">
                    <label for="title" class="labelEditerTitle">Titre du chapitre</label>
                    <input type="text" name="title"  class="inputEditerTitle" value="<?php if(isset($modified)): ?> <?= $data['title'] ?> <?php endif ?>"/>
                </div>

                <div class="divEditer form-group col-lg-3">
                    <label for="author" class="labelEditerAuthor">Auteur</label>
                    <input type="text" name="author" class="inputEditerAuthor" value="<?php if(isset($modified)): ?> <?= $data['author'] ?> <?php endif ?>"/>
                </div>
            </div>

            <div class="form-group">
                <textarea id="editer" name="content"><?php if(isset($modified)): ?> <?= $data['content'] ?> <?php endif ?></textarea>
            </div>

            <div class="row rowButton">
                <?php if (isset($error)): ?>
                    <div class="alert alert-block alert-danger text-center col-sm-9">
                    Tous les champs doivent être remplis !
                    </div>
                <?php endif ?> 

                <input type="file" name="upload" value="Ajouter une image" class="file"/>
                <button id="buttonEditor" name="button" class="btn btn-primary pull-right col-sm-2">Envoyer</button>
            </div>
        </form>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('templateEditor.php'); ?>
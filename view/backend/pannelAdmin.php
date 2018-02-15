<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<div id="containerListerChapiter" class="container">
    <p class=""><a href="index.php">Retour vers l'accueil du site</a></p>

    <div class="row">
        <h2 class="col-sm-offset-4 col-sm-3">Liste des chapitres</h2>
        <a class="btn btn-primary btnAdd" href="index.php?action=administration&amp;editer&amp;id=0" data-toggle="tooltip" data-placement="right" title="Ajoutez un chapitre"><i class="fas fa-plus-circle fa-4x"></i></a>
    </div>


    <div class="row">
        <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Modification</th>
            </tr>

            <?php while($data = $listPosts->fetch()): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td><br>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center">
                        <a href="index.php?action=administration&amp;editer&amp;id=<?= $data['id'] ?>">Modifier</a>
                        <a href="index.php?action=administration&amp;delete&amp;id=<?= $data['id'] ?>" style="padding-left: 10px;">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="row">
        <h2 class="col-sm-offset-4 col-sm-2">Corbeille</h2>
        <a href="index.php?action=administration&amp;trash" class="linkTrash col-sm-1" >Vider</a>
    </div>
</div>


<?php $listPosts->closeCursor(); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<p class="col-lg-offset-1"><a href="index.php">Retour vers l'accueil du site</a></p>

<div class="row">
    <h2 class="col-sm-offset-4 col-sm-2">Liste des chapitres :</h2>
    <p class="col-sm-2 buttonAddAdmin"><a href="index.php?action=administration&amp;editer">Ajouter</a></p>
</div>

<div class="row">
    <div id="containerListerChapiter" class="container">
        <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
            <tr>
                <th class="text-center lineTitle">Titres du chapitre</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Modification</th>
            </tr>

            <?php while($data = $listPosts->fetch()): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td><br>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php $listPosts->closeCursor(); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
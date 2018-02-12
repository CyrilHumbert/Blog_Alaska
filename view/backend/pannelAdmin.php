<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<div class="row">
    <h2 class="col-sm-offset-4 col-sm-2">Liste des chapitres :</h2>
    <p class="col-sm-2 buttonAddAdmin"><a href="index.php?action=login&amp;editor">Ajouter</a></p>
</div>

<div class="container">
    <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
        <tr>
            <th class="text-center lineTitle">Titres du chapitre</th>
            <th class="text-center">Modification</th>
        </tr>

        <?php while($data = $listPosts->fetch()): ?>
            <tr>
                <td class="text-center lineTitle"><?= $data['title'] ?></td><br>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php $listPosts->closeCursor(); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
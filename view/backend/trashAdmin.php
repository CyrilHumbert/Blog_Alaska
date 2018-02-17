<?php $title = "Pannel d'administration - Corbeille"; ?>

<?php ob_start(); ?>

<div class="container">

    <div class="row">
        <h2 class="text-center">Chapitres supprimés</h2>
    </div>

    <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center">Nombre de vues</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Supression</th>
            </tr>

            <?php foreach($listPosts as $row => $data): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td>
                    <td class="text-center"><?= $data['nb_views'] ?></td>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center">
                        <a href="index.php?action=administration&amp;trash&amp;restore&amp;id=<?= $data['id_chapter'] ?>">Restaurer</a>
                        <a href="index.php?action=administration&amp;trash&amp;deletetrash&amp;id=<?= $data['id'] ?>" style="padding-left: 10px;">Supprimer définitivement</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
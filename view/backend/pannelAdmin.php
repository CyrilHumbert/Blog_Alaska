<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<h2>Gestion des chapitres :</h2>

<table class="table">
    <tr>
        <th>Titres du chapitre</th>
        <th>Modification</th>
    </tr>

    <tr>
        <?php
        while($listPosts) {
            ?>
            <th><?= $listPosts['title'] ?></th>
            <?php
        }
        ?>
    </tr>
</table>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
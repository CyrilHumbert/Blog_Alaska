<?php $title = 'Modification de commentaire'; ?>

<?php ob_start(); ?>

<p><a href="index.php?action=post&id=<?= $_GET['idp'] ?>">Retour au chapitre</a></p>

<h2>Commentaires</h2>

<form action="index.php?action=modifComment&amp;id=<?= $_GET['id'] ?>&amp;idp=<?= $_GET['idp']?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author"  value="<?= $data['author']; ?>" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"><?= $data['comment']; ?></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
<?php $title = 'Modification de commentaire'; ?>

<?php ob_start(); ?>

<header id="headerBan" class="row">
    <div class="container-fluid">
        <div class="row" id="firstLine">
            <h1 id="titleAlaska" class="col-sm-offset-1 col-md-offset-2 col-lg-offset-2 col-lg-8">Billet simple pour l'Alaska</h1>
        </div>
        
        <div class="row" id="secondeLine">
            <h1 id="titleJeanForteroche" class="col-lg-offset-6 col-sm-6 pull-right">De Jean Forteroche</h1>
        </div>
    </div> 
</header>

<p><a href="index.php?action=post&id=<?= $_GET['idp'] ?>">Retour au chapitre</a></p>

<h2>Commentaires</h2>

<form action="index.php?action=modifComment&amp;id=<?= $_GET['id'] ?>&amp;idp=<?= $_GET['idp']?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author"  value="<?= $commentModifView['author']; ?>" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"><?= $commentModifView['comment']; ?></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
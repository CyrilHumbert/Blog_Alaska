<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>
<p><a href="index.php">Retour à la liste des chapitres</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post['title']) ?>
        <em>le <?= $post['creation_date_fr'] ?></em>
    </h3>
    
    <p>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>
</div>

<h2 id="titleComment">Commentaires</h2>

<?php
$count = 0;

while ($comment = $comments->fetch())
{
?>
    <p class="anotComment"><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?> (<a href="index.php?action=modifComment&amp;id=<?= $comment['id']?>&amp;idp=<?= $_GET['id']?>">modifier</a>)</p>
    <p class="commentContent"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
$count++;
}
?>

<p style="text-align: center; font-weight: bold;">Commentaire totaux : <?= $count; ?></p>

<form id="formAddComment" action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

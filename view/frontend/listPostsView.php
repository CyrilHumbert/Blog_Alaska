<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<p id="textWelcome">Celui-ci sera dédié entièrement à la publication de mon dernier roman "Billet simple pour l'Alaska", cette fois-ci il sera publié un nouveau chapitre du roman toutes les semaines en ligne sur ce blog.</br>
    Ainsi vous pourrez profiter gratuitement de celui-ci et en plus vous pouvez partager vos avis sur les différents chapitre !</br>
Alors profitais en et j'attend vos retours avec impatience !</p>

<h2 id="titreLastNews">Derniers chapitre du blog :</h2>

<?php
while ($data = $posts->fetch())
{
?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($data['title']) ?>
            <em>le <?= $data['creation_date_fr'] ?></em>
        </h3>
        
        <p>
            <?= nl2br(htmlspecialchars($data['content'])) ?>
            <br />
            <em><a href="index.php?action=post&amp;id=<?= $data['id'] ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
$posts->closeCursor();
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
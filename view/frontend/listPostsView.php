<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<div class="container">
    <div class="row">
        <p id="textWelcome">
            Celui-ci sera dédié entièrement à la publication de mon dernier roman "Billet simple pour l'Alaska", cette fois-ci il sera publié un nouveau chapitre du roman toutes les semaines en ligne sur ce blog.</br>
            Ainsi vous pourrez profiter gratuitement de celui-ci et en plus vous pouvez partager vos avis sur les différents chapitre !</br>
            Alors profitais en et j'attend vos retours avec impatience !
        </p>
    </div>
    
    <div class="page-header">
        <h2 id="titreLastNews">Derniers chapitre du blog :</h2>
    </div>


    <div id="containerOfChapiter" class="row">
        <?php while ($data = $posts->fetch()): ?>
            <div class="chapterContainer col-lg-4">
                <div class="chapterContent">
                    <h3>
                        <?= $data['title'] ?>
                    </h3>

                    <p>
                        <em>publié le <?= $data['creation_date_fr'] ?> par <?= $data['author'] ?></em>
                    </p>
                    
                    <p>
                        <em><a href="index.php?action=chapter&amp;id=<?= $data['id'] ?>">Voir le chapitre</a></em>
                    </p>
                </div>
            </div>
        <?php endwhile ?>
    </div>

    <?php $posts->closeCursor(); ?>

</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
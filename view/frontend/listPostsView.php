<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<header id="headerBanAccueil" class="row">
    <div class="container-fluid">
        <div class="row">
            <h1 id="titleAlaska" class="col-sm-offset-1 col-md-offset-2 col-lg-offset-3 col-lg-8">Billet simple pour l'Alaska</h1>
        </div>
        
        <div class="row">
            <h1 id="titleJeanForteroche" class="col-lg-offset-6 col-sm-6">De Jean Forteroche</h1>
        </div>
    </div> 
</header> 

<div class="container">
    <div class="row">
        <p id="textWelcome">
            Celui-ci sera dédié entièrement à la publication de mon dernier roman "Billet simple pour l'Alaska", cette fois-ci un nouveau chapitre du roman sera publié toutes les semaines en ligne sur ce blog.</br>
            Ainsi vous pourrez profiter gratuitement de celui-ci et en plus vous pourrez partager vos avis sur les différents chapitre !</br>
            Alors profitais en et j'attends vos retours avec impatience !
        </p>
    </div>
    
    <div class="page-header">
        <h2 id="titreLastNews">Derniers chapitre du blog</h2>
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
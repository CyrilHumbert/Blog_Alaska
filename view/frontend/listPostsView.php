<?php $title = 'Accueil - Blog Alaska'; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBanAccueil" class="row">
            <div  class="col-sm-offset-1 col-md-offset-2 col-lg-offset-2 col-lg-8">
                <h1 id="titleAlaska">Billet simple pour l'Alaska</h1>
            </div>
            
            <div class="col-xs-offset-2 col-sm-offset-6 col-md-offset-6 col-lg-offset-6 col-lg-6">
                <h1 id="titleJeanForteroche" >De Jean Forteroche</h1>
            </div>
    </header> 
</div>

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


    <div id="contentChapter" class="row">
        <?php foreach ($posts as $raw => $data): ?>
            <div class="chapterContainer col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="chapterContent">
                    <img src="public/images/b_1_q_0_p_0.jpg" class="imgBook">

                    <h3 class="text-center titleChapterAccueil">
                        <?= $data['title'] ?>
                    </h3>

                    <p class="text-center assetChapter">
                        <?= $data['nb_views'] ?> vue<?php if($data['nb_views'] > 1): ?>s<?php endif; ?>, publié le <?= $data['creation_date_fr'] ?> par <?= $data['author'] ?>
                    </p>
                    

                        <a href="index.php?action=chapter&amp;id=<?= $data['id'] ?>" class="btn btn-default btnChapterAccueil">Voir le chapitre</a>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="page_navigation" class="text-center"> </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('templateAccueil.php'); ?>
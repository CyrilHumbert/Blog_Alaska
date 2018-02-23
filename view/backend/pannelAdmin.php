<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBanPannelAdmin" class="row">
        <div class="row" id="firstLinePannelAdmin">
            <h1 id="titleAdmin" class="text-center">Administration</h1>
        </div>
    </header>
</div>  

<div id="containerListerChapiter" class="container">
    <a href="index.php">Retour vers l'accueil du site</a>

    <!-- En-tête tableau admin chapitre -->
    <div class="row">
        <h2 class="text-center">Liste des chapitres<a href="index.php?action=administration&amp;editer&amp;id=0" class="linkAdd"><span class="glyphicon glyphicon-plus btnAdd" data-toggle="tooltip" data-placement="right" title="Ajouter un chapitre"></span></a></h2>
    </div>

    <!-- Tableau admin des chapitres -->
    <div class="row">
        <table id="tableAdminChapiter" class="table table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center lineView">Nombre de vues</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">État</th>
                <th class="text-center">Action</th>
            </tr>

            <?php if(empty($listPosts)): ?>
                <tr>
                    <td colspan="5" class="text-center">AUCUN CHAPITRE EXISTANT</td>
                </tr>
            <?php endif; ?>
            <?php foreach($listPosts as $raw => $data): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td>
                    <td class="text-center lineView"><?= $data['nb_views'] ?></td>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center"><?php if($data['status_post'] == 0): ?>Publié<?php else: ?>Brouillon<?php endif; ?></td>
                    <td class="text-center">
                    <a href="#"></a>
                        <a href="index.php?action=administration&amp;editer&amp;id=<?= $data['id'] ?>"><span class="glyphicon glyphicon-pencil btnModif" data-toggle="tooltip" data-placement="top" title="Modifier le chapitre"></span></a>
                        <a data-toggle="modal" href="#infos<?= $data['id'] ?>" class="linkInTab"><span class="glyphicon glyphicon-remove btnDel" data-toggle="tooltip" data-placement="right" title="Supprimer le chapitre" ></span></a>
                        <!-- Modal suppression d'un chapitre -->
                        <div class="modal fade" id="infos<?= $data['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer ce chapitre ?<br>
                                        Celui-ci sera placé dans la corbeille ainsi que les commentaires lié à celui-ci.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;delete&amp;id=<?= $data['id'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin modal -->
                    </td>
                </tr>
                <tr style="display: none;">
                    <td colspan="5">
                        <div class="media" style="width: 100%">
                            <div class="media-heading"><?= $data['title'] ?></div>
                            
                            <div class="media-body"><?= $data['content'] ?></div>

                            <div class="text-center">
                                <a href="#">Voir les commentaires</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Fin tableau admin chapitre -->

    <!-- Tableau commentaire signalé -->
    <div class="row">
        <?php $countSignal = count($listSignalComments) ?>
<h2 class="text-center"><?php if($countSignal <= 1): ?>Commentaire signalé<?php else: ?>Commentaires signalés<?php endif ?><span class="badge nbSignal pulse" style="margin-left: 10px;"><?= $countSignal ?></span></h2>
        <table id="tableAdminChapiter" class="table table-bordered table-condensed table-responsive">
            <tr>
                <th class="text-center lineTitle">Commentaire</th>
                <th class="text-center">Auteur du commentaire</th>
                <th class="text-center">Date du commentaire</th>
                <th class="text-center">Action</th>
            </tr>

            <?php if(empty($listSignalComments)): ?>
                <tr>
                    <td colspan="4" class="text-center">AUCUN COMMENTAIRE SIGNALÉ</td>
                </tr>
            <?php endif; ?>
            <?php foreach($listSignalComments as $rawSignal => $dataSignal): ?>
                <tr>
                    <td class="text-center lineTitle"><?= htmlspecialchars($dataSignal['comment']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($dataSignal['author']) ?></td>
                    <td class="text-center lineAuthor"><?= $dataSignal['comment_date_fr'] ?></td>
                    <td class="text-center">
                        <a data-toggle="modal" href="#infosModereComment<?= $dataSignal['id'] ?>"><span class="glyphicon glyphicon-alert btnMod" data-toggle="tooltip" data-placement="top" title="Modérer le commentaire"></span></a>
                        <!-- Modal modération d'un commentaire signalé -->
                        <div class="modal fade" id="infosModereComment<?= $dataSignal['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment modérer ce commentaire ?<br>
                                        Le contenu de celui-ci sera remplacé par :<br>
                                        "Ce commentaire à été modéré car il contenait des propos diffamatoires, injurieux ou illégaux - Jean Forteroche"
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;comment&amp;modere&amp;id=<?= $dataSignal['id'] ?>" class="btn btn-info pull-left">Modérer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                        <a data-toggle="modal" href="#infosDeleteComment<?= $dataSignal['id'] ?>" class="linkInTab"><span class="glyphicon glyphicon-remove btnDel" data-toggle="tooltip" data-placement="top" title="Supprimer le commentaire"></span></a>
                        <!-- Modal suppresion d'un commentaire signalé -->
                        <div class="modal fade" id="infosDeleteComment<?= $dataSignal['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer ce commentaire ?<br>
                                        Celui-ci sera définitivement supprimé ainsi que tout les commentaires lié à lui.<br>
                                        Il vous sera IMPOSSIBLE de le restaurer.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;comment&amp;deletecomment&amp;signal&amp;id=<?= $dataSignal['id'] ?>&amp;response=<?= $dataSignal['have_response'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                        <a data-toggle="modal" href="#infosAproveComment<?= $dataSignal['id'] ?>" class="linkInTab"><span class="glyphicon glyphicon-ok btnApr" data-toggle="tooltip" data-placement="right" title="Approuver le commentaire"></span></a>
                        <!-- Modal approuve d'un commentaire signalé -->
                        <div class="modal fade" id="infosAproveComment<?= $dataSignal['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment approuver ce commentaire ?<br>
                                        Celui-ci ne sera plus considérer comme signalé.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;comment&amp;aprove&amp;id=<?= $dataSignal['id'] ?>" class="btn btn-info pull-left">Approuver</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Redirection vers la corbeille -->
    <div class="row">
        <h2 class="text-center">Corbeille<a href="index.php?action=administration&amp;trash" class="linkAdd"><span class="glyphicon glyphicon-trash btnTrash" data-toggle="tooltip" data-placement="right" title="Vider la corbeille" ></span></a></h2>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
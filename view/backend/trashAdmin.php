<?php $title = "Corbeille - Administration"; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBanTrash" class="row">
        <div class="btnRetourPannel">
            <a href="index.php?action=administration" class="btn linkRetourPannel">Retour à l'administration</a>
        </div>

        <div>
            <h1 id="titleTrash" class="text-center">Corbeille</h1>
        </div>
    </header>
</div>

<div class="container">

    <div class="row">
        <h2 class="text-center">Chapitres supprimés</h2>
    </div>

    <!-- TABLEAU DES CHAPITRES EN CORBEILLE -->
    <table id="tableAdminChapiter" class="table table-responsive table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center">Nombre de vues</th>
                <th class="text-center lineAuthor">Auteur</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>

            <?php if(empty($listPostsTrash)): ?>
                <tr>
                    <td colspan="5" class="text-center">AUCUN CHAPITRE DANS LA CORBEILLE</td>
                </tr>
            <?php endif; ?>
            <?php foreach($listPostsTrash as $row => $data): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td>
                    <td class="text-center"><?= $data['nb_views'] ?></td>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center"><?php if($data['status_post'] == 0): ?>Publié<?php else: ?>Brouillon<?php endif; ?></td>
                    <td class="text-center">
                    <a data-toggle="modal" href="#infosDeleteTrash<?= $data['id'] ?>"><span class="glyphicon glyphicon-remove btnDel" data-toggle="tooltip" data-placement="top" title="Supprimer définitivement le chapitre"></span></a>
                        <!-- Modal suppresion corbeille d'un chapitre -->
                        <div class="modal fade" id="infosDeleteTrash<?= $data['id'] ?>">
                            <div class="modal-dialog modalRespon">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer ce chapitre de la corbeille ?<br>
                                        Celui-ci sera définitivement supprimé ainsi que tous les commentaires lié à lui.<br>
                                        Vous ne pourrez plus le restaurer.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;trash&amp;deletetrash&amp;id=<?= $data['id'] ?>&amp;idp=<?= $data['id_chapter'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                    <a data-toggle="modal" href="#infosRestore<?= $data['id'] ?>" class="linkInTab"><span class="glyphicon glyphicon-repeat btnRestore" data-toggle="tooltip" data-placement="right" title="Restaurer le chapitre"></span></a>
                        <!-- Modal restauration d'un chapitre en corbeille -->
                        <div class="modal fade" id="infosRestore<?= $data['id'] ?>">
                            <div class="modal-dialog modalRespon">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment restaurer ce chapitre ?<br>
                                        Celui-ci sera restauré avec son ancien status ainsi que tous ses commentaires.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;trash&amp;restore&amp;id=<?= $data['id_chapter'] ?>" class="btn btn-info pull-left">Restaurer</a>
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

        <div class="row">
            <h2 class="text-center">Commentaires supprimés</h2>
        </div>

        <!-- TABLEAU DES COMMENTAIRES EN CORBEILLE -->
        <table id="tableAdminCommenter" class="table table-responsive table-condensed">
            <tr>
                <th class="text-center lineTitle">Commentaire</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
            </tr>

            <?php if(empty($listCommentsTrash)): ?>
                <tr>
                    <td colspan="4" class="text-center">AUCUN COMMENTAIRE DANS LA CORBEILLE</td>
                </tr>
            <?php endif; ?>
            <?php foreach($listCommentsTrash as $rowComment => $dataComment): ?>
                <tr>
                    <td class="text-center lineTitle"><?= htmlspecialchars($dataComment['comment']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($dataComment['author']) ?></td>
                    <td class="text-center"><?= $dataComment['comment_date_fr'] ?></td>
                    <td class="text-center">
                    <a data-toggle="modal" href="#infosDeleteTrashComment<?= $dataComment['id'] ?>"><span class="glyphicon glyphicon-remove btnDel" data-toggle="tooltip" data-placement="top" title="Supprimer définitivement le commentaire"></span></a>
                    <!-- Modal suppresion corbeille d'un commentaire -->
                    <div class="modal fade" id="infosDeleteTrashComment<?= $dataComment['id'] ?>">
                        <div class="modal-dialog modalRespon">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Confirmation</h4>
                                </div>

                                <div class="modal-body">
                                    Voulez-vous vraiment supprimer ce commentaire de la corbeille ?<br>
                                    Celui-ci sera définitivement supprimé ainsi que tous les commentaires lié à lui.<br>
                                    Vous ne pourrez plus le restaurer.
                                </div>

                                <div class="modal-footer">
                                    <a href="index.php?action=administration&amp;comment&amp;deletecomment&amp;trashcomment&amp;id=<?= $dataComment['id_before_delete'] ?>&amp;idc=<?= $dataComment['id_comment'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                    <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN MODAL -->
                    <?php if($dataComment['delete_manual'] == 0): ?><span class="glyphicon glyphicon-repeat btnRestore btnDesactived linkInTab" data-toggle="tooltip" data-placement="right" title="Ce commentaire est lié à un chapitre supprimé"></span>
                    <?php elseif($dataComment['comment_principal_delete'] == 1): ?><span class="glyphicon glyphicon-repeat btnRestore btnDesactived linkInTab" data-toggle="tooltip" data-placement="right" title="Ce commentaire est lié à un commentaire supprimé"></span>
                    <?php else: ?><a data-toggle="modal" href="#infosRestoreComment<?= $dataComment['id'] ?>" class="linkInTab"><span class="glyphicon glyphicon-repeat btnRestore" data-toggle="tooltip" data-placement="right" title="Restaurer le commentaire"></span></a>
                        <!-- Modal restauration d'un commentaire en corbeille -->
                        <div class="modal fade" id="infosRestoreComment<?= $dataComment['id'] ?>">
                            <div class="modal-dialog modalRespon">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment restaurer ce commentaire ?<br>
                                        Celui-ci sera restauré ainsi que tous les commentaires en réponse à lui.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;comment&amp;restorecomment&amp;id=<?= $dataComment['id_before_delete'] ?>&amp;idc=<?= $dataComment['id_comment'] ?>" class="btn btn-info pull-left">Restaurer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                    <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>
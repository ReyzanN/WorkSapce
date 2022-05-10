<?php
/*
 * Copyright (c) 2022. -- Reyzan [ Gaétan S.CH ]
 */
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1><?php echo $InfoWorkSpace[0] ?> / Home</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Mon Compte</a></li>
                <li class="breadcrumb-item"><?php echo $InfoWorkSpace[0] ?></li>
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-house-fill"></i> / Acceuil</h5>
                        <p>Bienvenue sur votre espace de travail</p>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><?php echo $HeaderMessage[0] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-circle"></i> / Nombre de membre sur l'espace</h5>
                        <p>..</p>
                        <h6 class="card-title"><i class="bi bi-clipboard"></i> / Opérateur de l'espace : </h6>
                        <ul>
                            <?php foreach ($OperatorList as $Operator){
                                ?>
                                <li><?php echo $Operator[0].' '.$Operator[1]?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> <i class="bi bi-person-workspace"></i> / Nombre de proffesseur sur l'espace</h5>
                        <p>..</p>
                        <h6 class="card-title"><i class="bi bi-clipboard"></i> / Proffesseur Référents l'espace : </h6>
                        <ul>
                            <p>FOREACH</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-house-fill"></i> / Ressource de l'espace</h5>
                        <button class="btn btn-primary" type="button">Ajouter une ressource</button>
                    </div>
                </div>
            </div>
        </div>


        <?php if ($PermissionUsers){ ?>
        <!-- Modal All For Administration -->
            <?php if ($PermissionUsers[3]) { ?>
                <!-- Modal edit Header Message -->
                <div class="modal fade" id="EditHeaderMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modification du message de l'espace</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="account.php?param=WorkSpaceEditHeaderMessage&WorkSpaceAccess=<?php echo $_REQUEST['WorkSpaceAccess'] ?>">
                                    <div class="mb-3">
                                        <h3 class="text-center"><label for="messageHeader" class="form-label">Message Actuel</label></h3>
                                        <textarea type="text" class="form-control" name="messageHeader" id="messageHeader" aria-describedby="messageHelp"><?php echo $HeaderMessage[0] ?></textarea>
                                        <div id="messageHelp" class="form-text">Merci d'avoir un message cohérent</div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Ok !</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($PermissionUsers[1]) { ?>
                <!-- Modal invite user -->
                <div class="modal fade" id="InviteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Inviter un utilisateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="account.php?param=WorkSpaceInvitationSend&WorkSpaceAccess=<?php echo $_REQUEST['WorkSpaceAccess'] ?>">
                                    <div class="mb-3">
                                        <h3 class="text-center"><label for="UsersToInvite" class="form-label">Membre Invitable</label></h3>
                                        <select class="form-select" aria-label="UsersToInvite" name="MembersToInviteId">
                                            <option selected>Selectionez un utilisateurs</option>
                                            <?php
                                                foreach ($MembersToInvite as $MembersInvite){
                                            ?>
                                                <option value="<?php echo $MembersInvite[0] ?>"><?php echo $MembersInvite[1].' '.$MembersInvite[2] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <div id="messageHelp" class="form-text">Attention à qui vous invitez sur l'espace</div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Ok !</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


        <?php } ?>
    </section>

</main><!-- End #main -->

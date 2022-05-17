<?php
/*
 * Copyright (c) 2022. -- Reyzan [ Gaétan S.CH ]
 */
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tableau de Bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="account.php">Acceuil</a></li>
                <li class="breadcrumb-item active">Tableau De Bord</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Members Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card members-card">
                            <div class="card-body">
                                <h5 class="card-title">Nombre de membre</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $InfoNumbersUsers[0] ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Members Card -->

                    <!-- Number WorkSpace Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card workspace-card">
                            <div class="card-body">
                                <h5 class="card-title">Nombre d'espace</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-workspace"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $NumbersWorkSpace[0] ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Number WorkSpace Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card pendindAsk-card">
                            <div class="card-body">
                                <h5 class="card-title">Demande en attente</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hourglass-top"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $CountPending[0] ?></h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Historique des demandes</h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Faite Par</th>
                                        <th scope="col">N° WorkSpace</th>
                                        <th scope="col">WorkSpace</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                     foreach ($JoinRequest as $Request){
                                    ?>
                                         <tr>
                                             <th scope="row"><a href="#"><?php echo $Request[0] ?></a></th>
                                             <td><?php echo $Request[2]." ".$Request[1] ?></td>
                                             <td><?php echo $Request[6] ?></td>
                                             <td><a href="#" class="text-primary"><?php echo $Request[3]?></a></td>
                                             <?php if ($Request[5] == 1){?>
                                                 <td><span class="badge bg-danger"><?php echo $Request[4] ?></span></td>
                                             <?php
                                             }elseif($Request[5] == 2) { ?>
                                             <td><span class="badge bg-success"><?php echo $Request[4] ?></span></td>
                                             <?php
                                             }elseif($Request[5] == 4) { ?>
                                                 <td><span class="badge bg-danger"><?php echo $Request[4] ?></span></td>
                                             <?php
                                             }elseif ($Request[5] == 3){
                                             ?>
                                             <td><span class="badge bg-warning"><?php echo $Request[4] ?></span></td>
                                             <?php if ($Request[5] == 3){?><td><a href="account.php?param=AcceptWorkSpaceInvitation&WorkSpaceId=<?php echo $Request[6] ?>&IdInvitation=<?php echo $Request[0]?>"><button class="btn btn-success btn" type="button">Accepter</button></a><?php } ?>
                                             <?php if ($Request[5] == 3){?><a href="account.php?param=DeniedWorkSpaceInvitation&WorkSpaceId=<?php echo $Request[6] ?>&IdInvitation=<?php echo $Request[0]?>"><button class="btn btn-danger btn" type="button">Refuser</button></a></td><?php } ?>
                                             <?php } ?>
                                         </tr>
                                    <?php
                                     }
                                     ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Espace dont je suis membre</h5>

                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">WorkSpace</th>
                                        <th scope="col">Propriétaire</th>
                                        <th scope="col">Membre Depuis</th>
                                        <th scope="col">Lien</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach ($InfoWorkSpaceUsers as $InfoWorkSpace){
                                    ?>
                                        <tr>
                                            <td><a href="#" class="text-primary fw-bold"><?php echo $InfoWorkSpace[0] ?></a></td>
                                            <td><?php echo $InfoWorkSpace[1] ?></td>
                                            <td class="fw-bold"><?php echo $InfoWorkSpace[3]."&nbsp;".$InfoWorkSpace[2]  ?></td>
                                            <td><?php echo $InfoWorkSpace[4] ?></td>
                                            <td><button class="btn btn-success btn" type="button"><a href='account.php?param=WorkSpace&WorkSpaceAccess=<?php echo $InfoWorkSpace[0]?>' style='color: white'>Accès à l'espace</a></button></td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Activitées du compte <span>| Tous</span></h5>
                    </div>
                </div><!-- End Recent Activity -->

                <!-- News & Updates Traffic -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Nouveauté &amp; Mise à jours <span>| Tous</span></h5>
                        </div><!-- End sidebar recent posts-->

                    </div>
                </div><!-- End News & Updates -->

            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->
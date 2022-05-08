<?php
/*
 * Copyright (c) 2022. -- Reyzan [ Gaétan S.CH ]
 */
?>
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="index.html">
                <i class="bi bi-grid"></i>
                <span>Tableau De Bord</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php if($PermissionUsers){ ?>
        <hr>
        <li class="nav-heading">Administration De l'Espace</li>
            <?php if ($PermissionUsers[3]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="" data-bs-toggle="modal" data-bs-target="#EditHeaderMessage">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Modifier le message d'accueil</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[1]){ ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-send"></i>
                    <span>Inviter un utilisateur</span>
                </a>
            </li>
            <?php } ?>
            <?php if ($PermissionUsers[3]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-person-x"></i>
                        <span>Expulser un utilisateur</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[5]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-person-workspace"></i>
                        <span>Ajouter un professeur</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[6]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-person-dash-fill"></i>
                        <span>Supprimer un professeur</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[7]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Ajouter un opérateur</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[2]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-shield-x"></i>
                        <span>Supprimer un opérateur</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($PermissionUsers[8]){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                        <i class="bi bi-paperclip"></i>
                        <span>Supprimer une ressource</span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>


        <hr>
        <li class="nav-heading">Autre</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="account.php">
                <i class="bi bi-person-circle"></i>
                <span>Retour à mon compte</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->
        <hr>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Assistance</span>
            </a>
        </li><!-- End Contact Page Nav -->
    </ul>

</aside><!-- End Sidebar-->
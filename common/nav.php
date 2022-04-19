<?php
ob_start();
?>
<div class="headernavigation">
    <div class="logo">
        <img src="http://localhost/Projet-Cabinet-Neuropsychologie/public/medias/logoaccueil.png" alt="logo cabinet" />
    </div>
    <!-- Navigation principale du site -->
    <nav>
        <ul>
            <li><a href="index.php?page=autrespages/home">Accueil</a></li>
            <li><a href="index.php?page=autrespages/neuropsy">La Neuropsychologie</a></li>
            <li class="sub-menu">
                <a href="#">Les Bilans</a>
                <ul>
                    <li><a href="index.php?page=bilans/objbilan">Les objectifs du bilan</a></li>
                    <li><a href="index.php?page=bilans/derbilan">Déroulement du bilan</a></li>
                    <li><a href="index.php?page=bilans/typebilan">Les types de bilans</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#">Les prises en charge</a>
                <ul>
                    <li><a href="index.php?page=priseencharges/remediation">La remédiation cognitive</a></li>
                    <li><a href="index.php?page=priseencharges/psychoeducation">La psychoéducation</a></li>
                    <li><a href="index.php?page=priseencharges/aidant">L'aide aux aidants</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#">Informations</a>
                <ul>
                    <li><a href="index.php?page=informations/autourbilan">Autour du bilan</a></li>
                    <li><a href="index.php?page=informations/tarifs">Tarifs</a></li>
                    <li><a href="index.php?page=informations/stage">Stagiaires</a></li>
                </ul>
            </li>
            <!-- Condition pour afficher l'onglet "Mon profil" ou "Connexion" -->
            <?php if (isset($_SESSION["etatConnexion"]) && $_SESSION["etatConnexion"] == 1) { ?>
            <li class="sub-menu">
                <a href="#">Mon espace</a>
                <ul>
                    <li><a href="index.php?page=profil/profil">Profil</a></li>
                    <li><a href="index.php?page=profil/liensutiles">Les liens utiles</a></li>
                    <li><a href="index.php?page=profil/telechargement">Téléchargements</a></li>
                    <li><a href="index.php?page=deconnexion">Se déconnecter</a></li>
                </ul>
            </li>
            <?php } else { ?>
            <li class="sub-menu">
                <a href="#">Connexion</a>
                <ul>
                    <li><a href="index.php?page=inscription">S'inscrire</a></li>
                    <li><a href="index.php?page=authentif">Se connecter</a></li>
                </ul>
            </li>
            <?php } ?>
            <!-- Fin de la condition -->
            <li><a href="index.php?page=autrespages/contact">Contact</a></li>
        </ul>
    </nav>
    <div class="menu-toggle">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </div>
</div>
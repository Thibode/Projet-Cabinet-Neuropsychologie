<?php
// accessibilité à la session courante de l'utilisateur
session_start();
//include('./common/functions.php');
// Affichage « de la partie haute » de votre site, commun à l'ensemble de votre site

include('./common/header.php');

// Pages autorisées : whitelist

include('./whitelist/web.php');


// Gestion de l'affichage de la page demandée
if (isset($_SESSION['id_groupe_utilisateur']) && $_SESSION['id_groupe_utilisateur'] == "4") {
    if (isset($_GET['page']) && in_array($_GET['page'], $whitelist)) {
        include('./common/navadmin.php');
        include("pages/" . $_GET['page'] . '.php');
    }
} elseif (isset($_GET['page']) && in_array($_GET['page'], $whitelist)) {
    include('./common/nav.php');
    include("pages/" . $_GET['page'] . '.php');
} else {
    //si le champ page n'est pas accessible dans l'URL OU que l'accès à la page n'est pas possible
    //alors on le ramène à l'acceuil
    header('Location: index.php?page=autrespages/home');
}
// Affichage de la partie basse de votre site, commun à l'ensemble de votre site. 
include('./common/footer.php');
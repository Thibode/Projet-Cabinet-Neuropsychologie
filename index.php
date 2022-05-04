<?php
// accessibilité à la session courante de l'utilisateur
session_start();
// Affichage « de la partie haute » de votre site, commun à l'ensemble de votre site

include('./common/header.php');

// Pages autorisées : whitelist

include('./whitelist/web.php');

//limiter le temps de la session
$timeSession = isset($_SESSION['timeLastAction']) ? $_SESSION['timeLastAction'] : time();
$timeCourant = time(); //nb s depuis le 01/01/70

// Gestion de l'affichage de la page demandée
if (isset($_SESSION['id_groupe_utilisateur']) && $_SESSION['id_groupe_utilisateur'] == 4) {
    if (isset($_GET['page']) && in_array($_GET['page'], $whitelist)) {
        include('./common/navadmin.php');
        include("pages/" . $_GET['page'] . '.php');
    }
} elseif (isset($_GET['page']) && in_array($_GET['page'], $whitelist)) {
    include('./common/nav.php');
    include("pages/" . $_GET['page'] . '.php');
} else {
    //si le champ page n'est pas accessible dans l'URL OU que l'accès à la page n'est pas possible
    //alors on demande une authentification
    //si le temps d'inactivité a été dépassé, détruire la session
    //et forcer une ré authentification
    if ($timeCourant - $timeSession >= 3600) {
        session_destroy();
        session_start();
    }
    session_regenerate_id();
    //alors on le ramène à l'acceuil
    header('Location: index.php?page=autrespages/home');
}
// Affichage de la partie basse de votre site, commun à l'ensemble de votre site. 
include('./common/footer.php');
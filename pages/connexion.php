<?php
//vérification de l'existance de l'identifiant et du mot de passe.
//chargement des paramètres de la BD et connexion
include('./utils/db.php');
$mail = htmlspecialchars($_POST['mail']);
$pwd = $_POST['pass'];
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE mail_utilisateur=?");
$stmt->execute([$mail]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
    //il y a un résultat donc l'utilisateur existe, maintenant vérification du mot de passe
    $pwdHashBD = $result['mdp_utilisateur'];
    if (password_verify($pwd, $pwdHashBD)) {
        //le mot de passe en BD(qui a été crypté en PHP avant insertion) correspond au mot de passe saisi par l'utilisateur
        $_SESSION["etatConnexion"] = "1";
        //toutes les informations concernant l'utilisateur pourront être accessible durant la session
        $_SESSION["id"] = $result['id_utilisateur'];
        $_SESSION["prenom"] = $result['prenom_utilisateur'];
        $_SESSION["nom"] = $result['nom_utilisateur'];
        $_SESSION["mail"] = $result['mail_utilisateur'];
        $_SESSION["adresse"] = $result['adresse_utilisateur'];
        $_SESSION["codepostal"] = $result['codepostal_utilisateur'];
        $_SESSION["ville"] = $result['ville_utilisateur'];
        $_SESSION["tel"] = $result['tel_utilisateur'];
        // Session Administrateur
        $_SESSION["id_groupe_utilisateur"] = $result['id_groupe_utilisateur'];
        //redirection vers la page d'accueil
        header("Location: index.php?page=autrespages/home");
        die();
    } else {
        //ce paramètre stocké en session permettra de savoir que la connexion a échoué
        //et donc d'afficher un message d'echec sur la page d'authentification
        $_SESSION["etatConnexion"] = "0";
        header("Location: index.php?page=authentif");
        die();
    }
} else {
    // l'identifiant n'existe pas
    $_SESSION["etatConnexion"] = "0";
    header("Location: index.php?page=authentif");
    die();
}
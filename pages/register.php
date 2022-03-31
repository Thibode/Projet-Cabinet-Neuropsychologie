<?php
include("./utils/db.php");

if (isset($_POST['register'])) {
    if (empty($_POST['mail'])) {
        echo "<p>Vous devez indiquer une adresse mail</p>";
    } elseif (empty($_POST['pass'])) {
        echo "<p>Vous devez indiquer un mot de passe</p>";
    } elseif (empty($_POST['name'])) {
        echo "<p>Vous devez indiquer un nom</p>";
    } elseif (empty($_POST['phone'])) {
        echo "<p>Vous devez indiquer un numéro de téléphone</p>";
    } elseif (empty($_POST['downloadValid'])) {
        echo "<p>Vous devez cocher la case</p>";
    } else {

        $stmt = $pdo->prepare("INSERT INTO utilisateurs(mail_utilisateur, mdp_utilisateur, tel_utilisateur, prenom_utilisateur, nom_utilisateur, id_groupe_utilisateur) VALUES(?,?,?,?,UPPER(?),?)");

        $mail = htmlspecialchars($_POST['mail']);
        $tel = htmlspecialchars($_POST['phone']);
        $pwdHash = htmlspecialchars($_POST['pass']);
        $prenom = htmlspecialchars($_POST['firstname']);
        $nom = htmlspecialchars($_POST['name']);

        $stmt->execute([$mail, password_hash($pwdHash, PASSWORD_DEFAULT), $tel, $prenom, $nom, $_POST['id_groupe_utilisateur']]);
        echo "<h1 style='text-align:center; text-decoration:underline; font-size:14px; margin:40px 0 40px 0;'>Votre compte a été créé.</h1>";
    }
    header('Location: index.php?page=autrespages/home');
    die();
}
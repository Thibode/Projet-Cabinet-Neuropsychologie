<?php
include("./utils/db.php");

/*info principale*/

$nom = htmlspecialchars($_POST['lastname']);
$prenom = htmlspecialchars($_POST['firstname']);
$adresse = htmlspecialchars($_POST['adresse']);
$cp = htmlspecialchars($_POST['codepostal']);
$ville = htmlspecialchars($_POST['ville']);

/*info contact */

$mail = htmlspecialchars($_POST['mail']);
$tel = htmlspecialchars($_POST['tel']);

/*info mot de passe*/

$pwdHash = htmlspecialchars($_POST['password']);
$confirm_pwd = htmlspecialchars($_POST['confirm-password']);

try {

    $stmt = $pdo->prepare('UPDATE utilisateurs SET nom_utilisateur=?, prenom_utilisateur=?, adresse_utilisateur=?, codepostal_utilisateur=?, ville_utilisateur=?, mail_utilisateur=?, tel_utilisateur=?, mdp_utilisateur=? WHERE id_utilisateur=?');

    $stmt->execute([$nom, $prenom, $adresse, $cp, $ville, $mail, $tel, password_hash($pwdHash, PASSWORD_DEFAULT), $_SESSION['id']]);

    $stmt->fetch();

    //Rafraichissement des données

    $_SESSION["nom_utilisateur"] = $nom;
    $_SESSION["prenom_utilisateur"] = $prenom;
    $_SESSION["adresse_utilisateur"] = $adresse;
    $_SESSION["codepostal_utilisateur"] = $cp;
    $_SESSION["ville_utilisateur"] = $ville;
    $_SESSION["mail_utilisateur"] = $mail;
    $_SESSION["tel_utilisateur"] = $tel;
    $_SESSION["mdp_utilisateur"] = $pwdHash;


    echo "<h1 style='text-align:center; text-decoration:underline; font-size:18px; margin:40px 0 40px 0;'>Modification effectuée.</h1>";
} catch (PDOException $e) {

    echo "Erreur  : " . $e->getMessage();
}
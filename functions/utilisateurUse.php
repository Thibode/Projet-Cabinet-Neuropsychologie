<?php
include("./utils/db.php");
//fonction qui renvoie l'id de l'utilisateur et son email
function getMail($pdoP, $mailP)
{
    $stmt = $pdoP->prepare("SELECT mail_utilisateur from utilisateurs WHERE mail_utilisateur = ?");
    $stmt->execute([$mailP]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result['mail_utilisateur'];
    }
    return null;
}
//fonction qui met à jour pour un identifiant donné la date du jeton et la valeur du jeton
//pour une réinitialisation du mot de passe
function updateToken($pdoP, $tokenP, $mailP)
{
    //ATTENTION l'identifiant doit être unique
    $stmt = $pdoP->prepare("UPDATE utilisateurs SET pwd_change_date = NOW(), pwd_change_token = ? WHERE mail_utilisateur = ?");
    $stmt->execute([$tokenP, $mailP]);
}
//fonction qui renvoie les infos spécifiques à un jeton passé en paramètre
function getInfosToken($pdoP, $tokenP)
{
    //ATTENTION l'identifiant doit être unique
    $stmt = $pdoP->prepare("SELECT pwd_change_date, id_utilisateur FROM utilisateurs WHERE pwd_change_token = ?");
    $stmt->execute([$tokenP]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//fonction qui modifie le mot de passe et enlève les infos concernant le token
function reinitPwd($pdoP, $values)
{
    //ATTENTION l'identifiant doit être unique
    $mail = htmlspecialchars($values['mail']);
    $pwd = htmlspecialchars($values['pwd']);
    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt = $pdoP->prepare("UPDATE utilisateurs SET pwd_change_date = NULL, pwd_change_token = NULL, mdp_utilisateur = ? WHERE mail_utilisateur = ?");
    $stmt->execute([$pwdHash, $mail]);
}
<?php
include('utils/db.php');
if (isset($_POST)) {
    $stmt = $pdo->prepare("INSERT INTO rendezvous(libelle_rdv, debut_rdv, fin_rdv, id_utilisateur)
    VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['postlibelleRdv'], $_POST['postdebRdv'], $_POST['postfinRdv'], $_POST['postpatientId']]);
    //Voir avec Marie les modifs à faire par rapport à ma bd et que mettre en place pour récupérer la liste des utilisateurs
} else {
    echo "Wooooo stop";
}
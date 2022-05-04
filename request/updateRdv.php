<?php
include('../utils/db.php');
include('../function/reservationUse.php');
try {
    updateRdv($pdo, $_POST['libelle_rdv'], $_POST['id_rdv']);
} catch (PDOException $e) {
    echo $e;
}
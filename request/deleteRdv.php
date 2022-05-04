<?php
include('../utils/db.php');
include('../function/rendezvousUse.php');
try {
    deleteRdv($pdo, $_POST['id_rdv']);
} catch (PDOException $e) {
    echo $e;
}
<?php
include('../utils/db.php');
include('../function/reservationUse.php');
try {
    echo createRdv($pdo, $_POST);
} catch (PDOException $e) {
    echo $e;
}
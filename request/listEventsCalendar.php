<?php
include('../utils/db.php');
include('../functions/rendezvousUse.php');

echo json_encode(getEvenementsRdv($pdo));
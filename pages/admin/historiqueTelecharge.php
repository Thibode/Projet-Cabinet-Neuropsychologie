<?php
include('./models/telechargement.php');
require('utils/db.php');
?>
<div class="global">
    <h2>Historique des téléchargements.</h2>
    <div class="underline"></div>
</div>
<div class="result">
    <?php
    Telechargement::histoTelechargement($pdo);
    ?>
</div>
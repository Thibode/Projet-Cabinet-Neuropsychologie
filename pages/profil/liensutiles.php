<div class="global">
    <h2>Liens utiles</h2>
    <div class="underline"></div>
    <div class="result">
        <?php
        include('./models/fichier.php');
        require('utils/db.php');

        Lien::afficheLienUser($pdo)

        ?>
    </div>
</div>
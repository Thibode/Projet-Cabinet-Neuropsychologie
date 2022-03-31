<main>
    <div class="global">
        <h1>Téléchargements</h1>
        <div class="result">
            <?php
            require('utils/db.php');
            include('./models/fichier.php');
            include('./models/telechargement.php');

            if (Fichier::downloadUser($_FILES, $_POST, $pdo)) {
            }

            if (isset($_POST["envoiIdSession"])) {
                Telechargement::recupTelechargement($_POST, $pdo);
            }
            ?>


        </div>
    </div>
</main>
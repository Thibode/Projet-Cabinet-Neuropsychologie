<?php
include('./models/fichier.php');
require('utils/db.php');

if (isset($_POST['envoiLien'])) {
    if (Lien::uploadLien($_POST, $pdo)) {
    }
}
if (isset($_POST['deleteLien'])) {
    if (Lien::deleteLien($_POST, $pdo)) {
    }
}
?>

<div class="global">
    <h2>Envoyer un lien</h2>
    <div class="underline"></div>

    <form action="index.php?page=admin/envoiLien" method="POST">
        <div class="champ positionText">
            <label for="intitule"></label>
            <input type="text" id="intitule_lien" name="intitule_lien" placeholder="Intitulé" required />
            <textarea name="description_lien" id="description_lien" cols="30" rows="1" placeholder="Description"
                required></textarea>
            <textarea name="url_lien" id="url_lien" cols="30" rows="1" placeholder="Url" required></textarea>
            <input type="submit" name="envoiLien" value="Envoyer le lien" />
        </div>
    </form>

    <h2>Liens enregistrés en base de données</h2>
    <div class="underline"></div>
    <div class="result">
        <?php
        if (Lien::afficheLien($pdo)) {
        }
        ?>
    </div>
</div>
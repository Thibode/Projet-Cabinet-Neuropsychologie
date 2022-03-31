<?php
include('./models/fichier.php');
require('utils/db.php');
if (isset($_POST['envoiFichier'])) {
    if (Fichier::upload($_FILES, $_POST, $pdo)) {
    }
}

if (isset($_POST['delete'])) {
    if (Fichier::deleteFichier($_POST, $pdo)) {
    }
}

if (isset($_POST['postEditId'])) {
    if (Fichier::modifFichier($_POST, $pdo)) {
    }
}
?>
<div class="global">
    <h2>Envoyer un fichier PDF</h2>
    <div class="underline"></div>
    <form action="index.php?page=admin/envoiFichier" method="POST" enctype="multipart/form-data">
        <!-- On utilise action pour relié notre fichier php qui contiendra 
            les scripts à executés pour l'envoie de nos fichiers, etant donné
            que l'on charge un fichier on indique enctype multipart/from-data-->

        <div class="champ positionText">
            <select name="listeDeroulante" id="listederoulante" required>
                <option value="1">Exercice</option>
                <option value="2">Documentation</option>
            </select>
            <label for="intitule"></label>
            <input type="text" id="intitule" name="intitule" placeholder="Intitulé" required />
            <input type="file" name="fichier" required /> <br />
            <textarea name="description" id="description" cols="30" rows="10" placeholder="Description"
                required></textarea>
            <input type="submit" name="envoiFichier" value="Envoyer le fichier" />
        </div>
    </form>

    <h2>Fichiers PDF enregistrés en base de données</h2>
    <div class="underline"></div>
    <div class="result">

        <?php
        if (Fichier::download($_FILES, $_POST, $pdo)) {
        }
        ?>
    </div>
</div>
<?php
include("modifModal.php");
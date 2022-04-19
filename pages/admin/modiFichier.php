<?php
include('./models/fichier.php');
require('utils/db.php');
if (isset($_POST['modiFichier'])) {

    $stmt = $pdo->prepare("SELECT libelle_pdf, description_pdf, exo_regle_pdf FROM pdf WHERE id_pdf=?");

    "<input type='hidden' name='idpdf' value='" . $datavalue['id_pdf'] . "'>
    <input type='hidden' name='libellepdf' value='" . $datavalue['libelle_pdf'] . "'>
    <input type='hidden' name='descripdf' value='" . $datavalue['description_pdf'] . "'>
    <input type='hidden' name='filespdf' value='" . $datavalue['exo_regle_pdf'] . "'>";
}
if (Fichier::modifFichier($_FILES, $_POST, $pdo)) {
}

?>
<div class="global">
    <h2>Modifier un fichier PDF</h2>
    <div class="underline"></div>
    <form action="index.php?page=admin/envoiFichier" method="POST" enctype="multipart/form-data">
        <!-- On utilise action pour relié notre fichier php qui contiendra 
            les scripts à executés pour l'envoie de nos fichiers, etant donné
            que l'on charge un fichier on indique enctype multipart/from-data-->

        <div class="champ positionText">
            <label for="intitule"></label>
            <input type="text" value="<?php echo $value['libelle_pdf'] ?>" id="modifIntitule" name="modifIntitule"
                placeholder="Intitulé" required />
            <input type="file" name="fichierModif" required /> <br />
            <textarea name="modifDescription" id="modifDescription" cols="30" rows="10" placeholder="Description"
                required></textarea>
            <input type="submit" name="modiFichier" value="Modifier le fichier" />
        </div>
    </form>
</div>
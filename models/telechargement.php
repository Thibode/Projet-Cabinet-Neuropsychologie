<?php

class Telechargement
{
    public static function recupTelechargement($values, $pdoP)
    {
        try {
            $idpdf = $values['envoiIdPdf'];
            $idSession = $values["envoiIdSession"];

            $stmt = $pdoP->prepare("INSERT INTO telecharger(id_pdf, id_utilisateur, DATE_Telechargement) VALUES(?,?,NOW())");

            $stmt->execute([$idpdf, $idSession]);

            return true;
        } catch (PDOException $e) {

            return false;
        }
    }
    public static function afficheTelechargement($pdoP)
    {
        $session = $_SESSION['id'];

        $stmt = $pdoP->prepare('SELECT libelle_pdf, exo_regle_pdf FROM pdf INNER JOIN telecharger ON pdf.id_pdf = telecharger.id_pdf INNER JOIN utilisateurs ON utilisateurs.id_utilisateur = telecharger.id_utilisateur WHERE utilisateurs.id_utilisateur=? GROUP BY libelle_pdf');
        $stmt->execute([$session]);
        $afficheData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='container mt-3'>
        <table class='table'>
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du fichier</th>
                <th>Télécharger</th> 
            </tr>
        </thead>
        <tbody>";
        foreach ($afficheData as $dataAfficheValue) {
            echo "<tr>
                    <td>" . $dataAfficheValue['libelle_pdf'] . "</td>
                    <td><a href=" . $dataAfficheValue['exo_regle_pdf'] . " download=" . $dataAfficheValue['exo_regle_pdf'] . ">
                    <img src='./public/medias/Downloadicon.png' style='width:15px; height:15px; margin-left:35px;'>
                    </a>
                    </td>
                    </tr>";
        }
        echo "</tbody>
        </table>
        </div>";
    }

    public static function histoTelechargement($pdoP)
    {
        $stmt = $pdoP->prepare("SELECT utilisateurs.nom_utilisateur, groupe_utilisateurs.libelle_groupe_utilisateur, telecharger.DATE_Telechargement, pdf.libelle_pdf FROM utilisateurs INNER JOIN groupe_utilisateurs ON utilisateurs.id_groupe_utilisateur = groupe_utilisateurs.id_groupe_utilisateur INNER JOIN telecharger ON telecharger.id_utilisateur = utilisateurs.id_utilisateur INNER JOIN pdf ON pdf.id_pdf = telecharger.id_pdf ORDER BY DATE_Telechargement DESC LIMIT 20");
        $stmt->execute();
        $afficheHisto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='container mt-3'>
        <table class='table'>
        <thead class=\"thead-light\">
            <tr>
                <th>Nom utilisateur</th>
                <th>Groupe utilisateur</th> 
                <th>Nom fichier</th> 
                <th>Date téléchargement</th> 
            </tr>
        </thead>
        <tbody>";
        echo '<form action = "index.php?page=admin/historiqueTelecharge" method = "post">
        <input type = "search" name = "motCle">
        <input type = "submit" name = "rechercheRapide">
        </form>';
        if (isset($_POST["rechercheRapide"])) {
            $terme = htmlspecialchars($_POST["motCle"]); //pour sécuriser le formulaire contre les failles html
            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
            if ($terme != '') {
                $terme = strtolower($terme);
                $stmt = $pdoP->prepare("SELECT utilisateurs.nom_utilisateur, groupe_utilisateurs.libelle_groupe_utilisateur, telecharger.DATE_Telechargement, pdf.libelle_pdf FROM utilisateurs INNER JOIN groupe_utilisateurs ON utilisateurs.id_groupe_utilisateur = groupe_utilisateurs.id_groupe_utilisateur INNER JOIN telecharger ON telecharger.id_utilisateur = utilisateurs.id_utilisateur INNER JOIN pdf ON pdf.id_pdf = telecharger.id_pdf WHERE libelle_pdf LIKE ? OR libelle_groupe_utilisateur LIKE ? ORDER BY DATE_Telechargement DESC LIMIT 10");
                $stmt->execute(array("%" . $terme . "%", "%" . $terme . "%"));
                $afficheHisto = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        foreach ($afficheHisto as $afficheHistoValue) {
            echo "<tr>
                    <td>" . $afficheHistoValue['nom_utilisateur'] . "</td>
                    <td>" . $afficheHistoValue['libelle_groupe_utilisateur'] . "</td>
                    <td>" . $afficheHistoValue['libelle_pdf'] . "</td>
                    <td>" . $afficheHistoValue['DATE_Telechargement'] . "</td>
                    </tr>";
        }
        echo "</tbody>
        </table>
        </div>";
    }
}
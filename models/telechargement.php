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

        $req = $pdoP->prepare('SELECT libelle_pdf, exo_regle_pdf FROM pdf INNER JOIN telecharger ON pdf.id_pdf = telecharger.id_pdf INNER JOIN utilisateurs ON utilisateurs.id_utilisateur = telecharger.id_utilisateur WHERE utilisateurs.id_utilisateur=? GROUP BY libelle_pdf;');
        $req->execute([$session]);
        $afficheData = $req->fetchAll(PDO::FETCH_ASSOC);

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
    public static function histoTelechargelent($pdoP)
    {
    }
}
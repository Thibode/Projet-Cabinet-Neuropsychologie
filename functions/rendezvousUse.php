<?php
// Fonction qui crée l'enregistrement en BD
function createRdv($pdoP, $vals)
{
    $stmt = $pdoP->prepare("INSERT INTO rendezvous(libelle_rdv, debut_rdv, fin_rdv, id_utilisateur)
    VALUES (?, ?, ?, ?)");
    $stmt->execute([$vals['postlibelleRdv'], $vals['postdebRdv'], $vals['postfinRdv'], $vals['postpatientId']]);
    //Voir avec Marie les modifs à faire par rapport à ma bd et que mettre en place pour récupérer la liste des utilisateurs
    return $pdoP->lastInsertId();
}
//fonction permettant de générer les événements du calendrier pour les rendez-vous
function getEvenementsRdv($pdoP)
{
    try {
        $stmt = $pdoP->prepare("SELECT libelle_rdv AS title, debut_rdv AS start, fin_rdv AS end from rendezvous");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}
function deleteRdv($pdoP, $idRdv)
{
    //pas de capture d'erreur pour qu'elle puisse remonter
    $stmt = $pdoP->prepare("DELETE FROM rendezvous WHERE id_rdv = ?");
    $stmt->execute([$idRdv]);
}
function updateRdv($pdoP, $libelleRdv, $idRdv)
{
    //pas de capture d'erreur pour qu'elle puisse remonter
    $stmt = $pdoP->prepare("UPDATE rendezvous SET libelle_rdv = ? WHERE id_rdv = ?");
    $stmt->execute([$libelleRdv, $idRdv]);
}
function recupRendezVous($pdoP)
{
    $session = $_SESSION['id'];

    $stmt = $pdoP->prepare('SELECT debut_rdv, fin_rdv FROM rendezvous WHERE id_utilisateur=?');
    $stmt->execute([$session]);
    $afficheRdv = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='container mt-3'>
        <table class='table'>
        <thead class=\"thead-light\">
            <tr>
                <th>Début</th> 
                <th>Fin</th> 
            </tr>
        </thead>
        <tbody>";
    foreach ($afficheRdv as $AfficheRdvDate) {
        echo "<tr>
                    <td>" . $AfficheRdvDate['debut_rdv'] . "</td>
                    <td>" . $AfficheRdvDate['fin_rdv'] . "</td>
            </tr>";
    }
    echo "</tbody>
        </table>
        </div>";
}
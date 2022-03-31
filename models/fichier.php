<?php

class Fichier
{
    public static function upload($filesP, $values, $pdoP)
    {
        if (!empty($filesP)) {

            $file_name = $filesP['fichier']['name']; // Information sur le nom du fichier
            $file_extension = strrchr($file_name, "."); // Information sur l'extension du fichier
            $file_size = $filesP['fichier']['size']; // Information sur la taille du fichier

            $file_tmp_name = $filesP['fichier']['tmp_name']; // Provenance du fichier
            $file_dest = 'files/' . $file_name; // Ici on indique la destination du fichier

            $extension_autorisees = array('.pdf', '.PDF'); // Ici on notera les extensions autorisées 
            $size_max = 10000000; // Ici on définira une taille maximale de notre fichier

            $intitule = htmlspecialchars($values['intitule']);
            $descrip = htmlspecialchars($values['description']);
            $isExercice = $_POST['listeDeroulante'] == 1;
            $isDoc = $_POST['listeDeroulante'] == 2;
            //Je déclare les variables lié aux champs du formulaire.

            if ($isExercice) {
                if (in_array($file_extension, $extension_autorisees) && $file_size <= $size_max) {
                    // Dans la condition ci-dessus on va voir dans un premier temps si l'extension du fichier correspond aux extensions autorisées.
                    // Par la suite on vérifie si la taille de notre fichier ne dépasse pas la taille max définie.
                    if (move_uploaded_file($file_tmp_name, $file_dest)) {
                        $req = $pdoP->prepare('INSERT INTO pdf(libelle_pdf, exo_regle_pdf, description_pdf, date_envoi_pdf, id_cat_pdf) VALUE (?, ?, ?, NOW(), 1)');
                        $req->execute(array($intitule, $file_dest, $descrip));

                        return true;

                        // Si tout est ok on envoie le fichier vers notre dossier de destination grace 
                        // à move_uploaded_file et on prépare l'insertion en base de données dans les différentes table.
                    }
                }
                return false;
            } elseif ($isDoc) {

                if (in_array($file_extension, $extension_autorisees) && $file_size <= $size_max) {

                    if (move_uploaded_file($file_tmp_name, $file_dest)) {
                        $req = $pdoP->prepare('INSERT INTO pdf(libelle_pdf, doc_pdf, description_pdf, date_envoi_pdf, id_cat_pdf) VALUE (?, ?, ?, NOW(), 2)');
                        $req->execute(array($intitule, $file_dest, $descrip));

                        return true;
                    }
                }
                return false;
            }
        }
    }

    public static function download($filesP, $values, $pdoP)
    {

        $req = $pdoP->prepare('SELECT id_pdf, libelle_pdf, exo_regle_pdf, description_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=1 ORDER BY date_envoi_pdf DESC LIMIT 10;');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        echo '<p class="lead text-center font-weight-bold">EXERCICES</p>';

        echo "<div class=\"container mt-3\"><table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du fichier</th>
                <th>Description</th>
                <th>Télécharger</th> 
                <th>Date Envoi</th>  
                <th></th>  
                <th></th>  
            </tr>
        </thead>
        <tbody>";
        echo '<form action = "index.php?page=admin/envoiFichier" method = "post">
        <input type = "search" name = "motCle">
        <input type = "submit" name = "rechercheRapide">
        </form>';
        if (isset($_POST["rechercheRapide"])) {
            $terme = htmlspecialchars($_POST["motCle"]); //pour sécuriser le formulaire contre les failles html
            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
            if ($terme != '') {
                $terme = strtolower($terme);
                $stmt = $pdoP->prepare("SELECT id_pdf, libelle_pdf, description_pdf, exo_regle_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=1 AND (libelle_pdf LIKE ? OR description_pdf LIKE ?) ORDER BY date_envoi_pdf DESC LIMIT 10");
                $stmt->execute(array("%" . $terme . "%", "%" . $terme . "%"));
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }

        foreach ($data as $datavalue) {
            echo "<tr id='" . $datavalue['id_pdf'] . "'>";
            echo "<td data-target='libelle'>" . $datavalue['libelle_pdf'] . "</td>";
            echo "<td data-target='description'>" . $datavalue['description_pdf'] . "</td>";
            echo '<td data-target="fichier">
            <a href="' . $datavalue['exo_regle_pdf'] . '"  download="' . $datavalue['exo_regle_pdf'] . '">
            <img src="./public/medias/Downloadicon.png" style="width:15px; height:15px; margin-left:35px;" >
            </a>
            </td>';
            echo "<td>" . $datavalue['date_envoi_pdf'] . "</td>";
            echo "<td>
                <button data-role='update' data-id='" . $datavalue['id_pdf'] . "' style='background:transparent; width:20px; height:20px;'>
                    <img src='./public/medias/modifier.png' style=\"width:20px; height:20px; cursor:pointer; margin-right:150px;\">
                </button>
                </td>";
            echo '<td>
                    <form method="POST" action="index.php?page=admin/envoiFichier">
                    <button type="submit" name="delete" style="background:none; width:20px; height:20px; cursor:pointer;" value="' . $datavalue['id_pdf'] . '">
                    <img src=\'./public/medias/supprimer.png\' style=\"width:20px; height:20px;\">
                    </button>
                    </form>                 
                </td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";
        //Ici nous allons retrouver le code permettant la recherche dans les différents tableaux du site.
        //Ici on connecte la base de données dans un premier temps.
        //Ensuite on va faire une requete pour allé chercher le nom et l'url du fichier afin de pouvoir le télécharger.
        //Par le suite on crée une boucle (foreach) afin d'afficher les différents fichiers uploader dans notre dossier files.
        //Tout est stocké dans un tableau fait avec Bootstrap.



        $req = $pdoP->prepare('SELECT id_pdf, libelle_pdf, doc_pdf, description_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=2 ORDER BY date_envoi_pdf DESC LIMIT 10;');
        $req->execute();
        $dataDoc = $req->fetchAll(PDO::FETCH_ASSOC);

        echo '<p class="lead text-center font-weight-bold">DOCUMENTATIONS</p>';
        echo "<div class=\"container mt-3\">
        <table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du fichier</th>
                <th>Description</th>
                <th>Télécharger</th>
                <th>Date Envoi</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>";
        echo '<form action = "index.php?page=admin/envoiFichier" method = "post">
        <input type = "search" name = "motCleDoc">
        <input type = "submit" name = "rechercheRapideDoc">
        </form>';
        if (isset($_POST["rechercheRapideDoc"])) {
            $termeDoc = htmlspecialchars($_POST["motCleDoc"]); //pour sécuriser le formulaire contre les failles html
            $termeDoc = trim($termeDoc); //pour supprimer les espaces dans la requête de l'internaute
            //$terme = strip_tags($terme); //pour supprimer les balises html dans la requête
            if ($termeDoc != '') {
                $termeDoc = strtolower($termeDoc);
                $stmt = $pdoP->prepare("SELECT id_pdf, libelle_pdf, description_pdf,  doc_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=2 AND (libelle_pdf LIKE ? OR description_pdf LIKE ?) ORDER BY date_envoi_pdf DESC LIMIT 10");
                $stmt->execute(array("%" . $termeDoc . "%", "%" . $termeDoc . "%"));
                $dataDoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }

        foreach ($dataDoc as $dataDocValue) {
            echo "<tr>";
            echo "<td>" . $dataDocValue['libelle_pdf'] . "</td>";
            echo "<td>" . $dataDocValue['description_pdf'] . "</td>";
            echo '<td><a href="' . $dataDocValue['doc_pdf'] . '"name="fichierTelecharge" target="_blank"><img src="./public/medias/Downloadicon.png"
                            style="width:15px; height:15px; margin-left:35px;"></a></td>';
            echo "<td>" . $dataDocValue['date_envoi_pdf'] . "</td>";

            echo "<td>
            <form method='POST' action='index.php?page=admin/modiFichier'>
            <button type='submit' name='modiFichier' style=\"background:none; width:20px; height:20px; cursor:pointer;\" value='" . $dataDocValue['id_pdf'] . "'><img src='./public/medias/modifier.png' style=\"width:20px; height:20px;\"></button></form></td>";
            echo '<td>
                    <form method="POST" action="index.php?page=admin/envoiFichier">
                    <button type="submit" name="delete" style="background:none; width:20px; height:20px; cursor:pointer;" value="' . $dataDocValue['id_pdf'] . '"><img src=\'./public/medias/supprimer.png\' style=\"width:20px; height:20px;\"></button>
                    </form>                 
                </td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }

    public static function deleteFichier($values, $pdoP)
    {
        try {
            $req = $pdoP->prepare('DELETE FROM pdf WHERE id_pdf=?');
            $req->execute([$values['delete']]);
            $delete = $req->fetchAll(PDO::FETCH_ASSOC);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function downloadUser($filesP, $values, $pdoP)
    {

        $req = $pdoP->prepare('SELECT id_pdf, libelle_pdf, exo_regle_pdf, description_pdf  FROM pdf WHERE id_cat_pdf=1 ORDER BY date_envoi_pdf DESC LIMIT 10;');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        echo '<p class="lead text-center font-weight-bold">EXERCICES</p>';

        echo "<div class=\"container mt-3\"><table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du fichier</th>
                <th>Description</th>
                <th></th>    
            </tr>
        </thead>
        <tbody>";

        echo '<form action = "index.php?page=profil/telechargement" method = "post">
        <input type = "search" name = "motCle">
        <input type = "submit" name = "rechercheRapide">
        </form>';
        if (isset($_POST["rechercheRapide"])) {
            $terme = htmlspecialchars($_POST["motCle"]); //pour sécuriser le formulaire contre les failles html
            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
            if ($terme != '') {
                $terme = strtolower($terme);
                $stmt = $pdoP->prepare("SELECT id_pdf, libelle_pdf, description_pdf, exo_regle_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=1 AND (libelle_pdf LIKE ? OR description_pdf LIKE ?) ORDER BY date_envoi_pdf DESC LIMIT 10");
                $stmt->execute(array("%" . $terme . "%", "%" . $terme . "%"));
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }


        foreach ($data as $datavalue) {
            echo "<tr>";
            echo "<td>" . $datavalue['libelle_pdf'] . "</td>";
            echo "<td>" . $datavalue['description_pdf'] . "</td>";
            echo '<td>
                    <a href="' . $datavalue['exo_regle_pdf'] . '" data-id="' . $datavalue['id_pdf'] . '" data-role="envoiData" download="' . $datavalue['exo_regle_pdf'] . '" 
                    >
                    <img src="./public/medias/Downloadicon.png" style="width:15px; height:15px; margin-left:35px;" ></a>
                    <input type="hidden" data-target="idSession" value="' . $_SESSION['id'] . '" >
                  </td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";

        // Ici on connecte la base de données dans un premier temps.
        // Ensuite on va faire une requete pour allé chercher le nom et l'url du fichier afin de pouvoir le télécharger.
        // Par le suite on crée une boucle (foreach) afin d'afficher les différents fichiers uploader dans notre dossier files.


        $req = $pdoP->prepare('SELECT libelle_pdf, doc_pdf, description_pdf FROM pdf WHERE id_cat_pdf=2 ORDER BY date_envoi_pdf DESC LIMIT 10;');
        $req->execute();
        $dataDoc = $req->fetchAll(PDO::FETCH_ASSOC);

        echo '<p class="lead text-center font-weight-bold">DOCUMENTATIONS</p>';

        echo "<div class=\"container mt-3\">
        <table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du fichier</th>
                <th>Description</th>
                <th>Télécharger</th>
            </tr>
        </thead>
        <tbody>";

        echo '<form action = "index.php?page=profil/telechargement" method = "post">
        <input type = "search" name = "motCleDoc">
        <input type = "submit" name = "rechercheRapideDoc">
        </form>';
        if (isset($_POST["rechercheRapideDoc"])) {
            $termeDoc = htmlspecialchars($_POST["motCleDoc"]); //pour sécuriser le formulaire contre les failles html
            $termeDoc = trim($termeDoc); //pour supprimer les espaces dans la requête de l'internaute
            //$terme = strip_tags($terme); //pour supprimer les balises html dans la requête
            if ($termeDoc != '') {
                $termeDoc = strtolower($termeDoc);
                $stmt = $pdoP->prepare("SELECT id_pdf, libelle_pdf, description_pdf,  doc_pdf, date_envoi_pdf FROM pdf WHERE id_cat_pdf=2 AND (libelle_pdf LIKE ? OR description_pdf LIKE ?) ORDER BY date_envoi_pdf DESC LIMIT 10");
                $stmt->execute(array("%" . $termeDoc . "%", "%" . $termeDoc . "%"));
                $dataDoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }

        foreach ($dataDoc as $dataDocValue) {
            echo "<tr>";
            echo "<td>" . $dataDocValue['libelle_pdf'] . "</td>";
            echo "<td>" . $dataDocValue['description_pdf'] . "</td>";
            echo '<td>
            <a href="' . $dataDocValue['doc_pdf'] . '" data-id="' . $dataDocValue['id_pdf'] . '" data-role="envoiData" download="' . $dataDocValue['doc_pdf'] . '">
            <img src="./public/medias/Downloadicon.png" style="width:15px; height:15px; margin-left:35px;" >
            </a>
            <input type="hidden" data-target="idSession" value="' . $_SESSION['id'] . '" >
            </td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }
    public static function modifFichier($values, $pdoP)
    {
        try {
            $stmt = $pdoP->prepare('UPDATE pdf SET libelle_pdf = ?, description_pdf =? WHERE id_pdf=?');
            $stmt->execute([$values['postLibelle'], $values['postDescription'], $values['postEditId']]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

class Lien
{
    public static function uploadLien($_postP, $pdoP)
    {
        $stmt = $pdoP->prepare("INSERT INTO liens(libelle_liens, description_liens, url_liens, date_envoi_liens) VALUES(?, ?, ?, NOW())");

        $intituleLien = htmlspecialchars($_POST['intitule_lien']);
        $descripLien = htmlspecialchars($_POST['description_lien']);
        $urlLien = htmlspecialchars($_POST['url_lien']);

        $stmt->execute(array($intituleLien, $descripLien, $urlLien));
    }

    public static function afficheLien($pdoP)
    {
        $req = $pdoP->prepare('SELECT id_liens, libelle_liens, description_liens, url_liens, date_envoi_liens FROM liens ORDER BY date_envoi_liens DESC LIMIT 10;');
        $req->execute();
        $dataLien = $req->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class=\"container mt-3\">
        <table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du lien</th>
                <th>Description</th>
                <th>URL</th>
                <th>Date envoi</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>";
        echo '<form action = "index.php?page=admin/envoiLien" method = "post">
        <input type = "search" name = "motCleLien">
        <input type = "submit" name = "rechercheRapideLien" style = "cursor:pointer;">
        </form>';
        if (isset($_POST["rechercheRapideLien"])) {
            $termeLien = htmlspecialchars($_POST["motCleLien"]); //pour sécuriser le formulaire contre les failles html
            $termeLien = trim($termeLien); //pour supprimer les espaces dans la requête de l'internaute
            //$terme = strip_tags($terme); //pour supprimer les balises html dans la requête
            if ($termeLien != '') {
                $termeLien = strtolower($termeLien);
                $stmt = $pdoP->prepare("SELECT id_liens, libelle_liens, description_liens,  url_liens, date_envoi_liens FROM liens WHERE libelle_liens LIKE ? OR description_liens LIKE ? ORDER BY date_envoi_liens DESC LIMIT 10;");
                $stmt->execute(array("%" . $termeLien . "%", "%" . $termeLien . "%"));
                $dataLien = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }
        foreach ($dataLien as $dataLienValue) {
            echo "<tr>";
            echo "<td>" . $dataLienValue['libelle_liens'] . "</td>";
            echo "<td>" . $dataLienValue['description_liens'] . "</td>";
            echo '<td><a href="' . $dataLienValue['url_liens'] . '"  target="_blank"><img src="./public/medias/fleche.png"
            style="width:15px; height:15px; margin-left:5px;"></a></td>';
            echo "<td> " . $dataLienValue['date_envoi_liens'] . "</td>";
            echo "<td>
            <form method='POST' action='index.php?page=admin/modifLien'>
            <button type='submit' name='modiFichier' style=\"background:none; width:20px; height:20px; cursor:pointer;\" value='" . $dataLienValue['id_liens'] . "'><img src='./public/medias/modifier.png' style=\"width:20px; height:20px;\"></button></form></td>";
            echo '<td>
                    <form method="POST" action="index.php?page=admin/envoiLien">
                    <button type="submit" name="deleteLien" style="background:none; width:20px; height:20px; cursor:pointer;" value="' . $dataLienValue['id_liens'] . '"><img src=\'./public/medias/supprimer.png\' style=\"width:20px; height:20px;\"></button>
                    </form>                 
                </td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }

    public static function deleteLien($value, $pdoP)
    {
        try {
            $req = $pdoP->prepare('DELETE FROM liens WHERE id_liens=?');
            $req->execute([$value['deleteLien']]);
            $deleteLien = $req->fetchAll(PDO::FETCH_ASSOC);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function afficheLienUser($pdoP)
    {
        $req = $pdoP->prepare('SELECT id_liens, libelle_liens, description_liens, url_liens FROM liens ORDER BY date_envoi_liens DESC LIMIT 10;');
        $req->execute();
        $dataLien = $req->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class=\"container mt-3\">
        <table class=\"table\">
        <thead class=\"thead-light\">
            <tr>
                <th>Nom du lien</th>
                <th>Description</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>";
        echo '<form action = "index.php?page=admin/envoiLien" method = "post">
        <input type = "search" name = "motCle">
        <input type = "submit" name = "rechercheRapide" style = "cursor:pointer;">
        </form>';
        if (isset($_POST["rechercheRapide"])) {
            $terme = htmlspecialchars($_POST["motCle"]); //pour sécuriser le formulaire contre les failles html
            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
            //$terme = strip_tags($terme); //pour supprimer les balises html dans la requête
            if ($terme != '') {
                $terme = strtolower($terme);
                $stmt = $pdoP->prepare("SELECT id_liens, libelle_liens, description_liens,  url_liens, date_envoi_liens FROM liens WHERE libelle_liens LIKE ? OR description_liens LIKE ? ORDER BY date_envoi_liens DESC LIMIT 10;");
                $stmt->execute(array("%" . $terme . "%", "%" . $terme . "%"));
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $message = "Vous devez entrer un mot clé dans la barre de recherche";
            }
        }
        foreach ($dataLien as $dataLienValue) {
            echo "<tr>";
            echo "<td>" . $dataLienValue['libelle_liens'] . "</td>";
            echo "<td>" . $dataLienValue['description_liens'] . "</td>";
            echo '<td><a href="' . $dataLienValue['url_liens'] . '"  target="_blank"><img src="./public/medias/fleche.png"
            style="width:15px; height:15px; margin-left:5px;"></a></td>';
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }
}
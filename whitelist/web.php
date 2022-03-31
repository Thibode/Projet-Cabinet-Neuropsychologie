<?php
$whitelist = array('inscription', 'authentif', 'connexion', 'register', 'mdpoublie', 'changementmdp', 'autrespages/home', 'autrespages/neuropsy', 'bilans/bilans', 'bilans/objbilan', 'bilans/derbilan', 'bilans/typebilan', 'priseencharges/prisesencharge', 'priseencharges/remediation', 'priseencharges/psychoeducation', 'priseencharges/aidant', 'informations/information', 'informations/autourbilan', 'informations/tarifs', 'informations/stage', 'autrespages/contact', 'deconnexion',);
if (isset($_SESSION["etatConnexion"]) && $_SESSION["etatConnexion"] == 1) {
    //     la connexion a été établie
    array_push($whitelist, 'profil/telechargement', 'profil/liensutiles', 'profil/profil', 'profil/profilModif', 'deconnexion');
    //     déclarer des accès specifique admin
    if (isset($_SESSION['id_groupe_utilisateur']) && $_SESSION['id_groupe_utilisateur'] == "4") {
        array_push($whitelist, 'admin/envoiFichier', 'admin/modiFichier', 'admin/envoiLien', 'admin/modifLien',  'admin/tableaudebord', 'admin/historiqueTelecharge', 'admin/contactDev');
    }
}
//$whitelistAdmin = array('tableaudebord', 'authentif', 'connexion', 'home', 'neuropsy', 'bilans', 'objbilan', 'derbilan', 'deconnexion');
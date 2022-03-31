<?php
include('models/telechargement.php');
require('utils/db.php');
?>
<div class="globalProfil">
    <div class="orgaItem">
        <div class="informationPerso">
            <h3>Mon profil</h3>
            <div class="underline"></div>

            <form class="formProfil" action="index.php?page=profil/profilModif" method="post" role="form">

                <h3>Information Personnelle</h3>

                <!--Champ pour le nom-->
                <div class="form-group">
                    <input type="text" name="lastname" id="lastname" tabindex="1" class="form-control"
                        placeholder="Nom de famille" value="<?php echo $_SESSION['nom'] ?>" required="true">
                </div>
                <!--Champ pour le prenom-->
                <div class="form-group">
                    <input type="text" name="firstname" id="firstname" tabindex="1" class="form-control"
                        placeholder="Prénom" value="<?php echo $_SESSION['prenom'] ?>" required="true">
                </div>
                <!--Champ pour l'adresse-->
                <div class="form-group">
                    <input type="text" name="adresse" id="adresse" tabindex="1" class="form-control"
                        placeholder="Adresse" value="<?php echo $_SESSION['adresse'] ?>" required="true">
                </div>
                <!--Champ pour le codepostal-->
                <div class="form-group">
                    <input type="text" name="codepostal" id="codepostal" tabindex="1" class="form-control"
                        placeholder="Code Postal" value="<?php echo $_SESSION['codepostal'] ?>" required="true">
                </div>
                <!--Champ pour la Ville-->
                <div class="form-group">
                    <input type="text" name="ville" id="ville" tabindex="1" class="form-control" placeholder="Ville"
                        value="<?php echo $_SESSION['ville'] ?>" required="true">
                </div>

                <h3>Moyen de contact</h3>

                <!--Champ pour le mail-->
                <div class="form-group">
                    <input type="email" name="email" id="email" tabindex="1" class="form-control"
                        placeholder="Adresse email" value="<?php echo $_SESSION['mail'] ?>" required="true">
                </div>
                <!--Champ pour le telephone-->
                <div class="form-group">
                    <input type="text" name="tel" id="tel" tabindex="1" class="form-control" placeholder="Téléphone"
                        value="<?php echo $_SESSION['tel'] ?>" required="true">
                </div>

                <h3>Mot de passe</h3>

                <!--Champ pour le mot de passe-->
                <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control"
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2"
                        class="form-control" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" name="register-submit" id="register-submit" tabindex="4"
                                class="form-control btn btn-danger" style="width:150px;" value="Mise à jour">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="informationSite">
            <h3>Mes téléchargements</h3>
            <div class="underline"></div>
            <div class="telechargement">
                <!--Tableau des derniers téléchargement effectué-->
                <?php
                $affiche = Telechargement::afficheTelechargement($pdo);
                if (isset($affiche)) {
                }
                ?>
            </div>
            <h3>Mes prochains rendez-vous</h3>
            <div class="underline"></div>
            <div class="rdv">
                <!--Tableau avec les prochains rendez-vous-->
            </div>
        </div>
    </div>
</div>
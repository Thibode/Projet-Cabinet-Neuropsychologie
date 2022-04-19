<main>
    <h1>Changement de mot de passe</h1>
    <div class="connexion">
        <form method="post" action="index.php?page=connexion">
            <div class="champ positionText">
                <label for="pass"></label>
                <div class="group-pass">
                    <input class="textconnexion" type="password" id="pass" name="pass"
                        placeholder="Nouveau mot de passe" required />
                    <div class="imgPassword">
                        <img id="eye" src="./public/medias/eye.svg" alt="affiche mot de passe" onclick="affiche()">
                    </div>
                </div>
            </div>
            <div class="champ positionText">
                <label for="pass"></label>
                <div class="group-pass">
                    <input class="textconnexion" type="password" id="pass" name="pass"
                        placeholder="Confirmer mot de passe" required />
                    <div class="imgPassword">
                        <img id="eye" src="./public/medias/eye.svg" alt="affiche mot de passe" onclick="affiche()">
                    </div>
                </div>
            </div>
            <!--bouton d'envoi du formulaire-->
            <div class="champ" id="button">
                <input class="btnconnexion" type="submit" value="Changer mot de passe" />
            </div>
        </form>
    </div>
</main>
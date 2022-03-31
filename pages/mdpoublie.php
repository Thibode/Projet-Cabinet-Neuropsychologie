<main>
    <h1>Mot de passe oublié ?</h1>
    <div class="connexion">
        <form method="post" action="index.php?page=connexion">
            <div class="champ positionText">
                <label for="mail"></label>
                <div class="group-pass">
                    <input class="textconnexion" type="email" id="mail" name="mail" placeholder="Adresse Mail" required
                        pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" />
                </div>
            </div>
            <!--bouton d'envoi du formulaire-->
            <div class="champ" id="button">
                <input class="btnconnexion" type="submit" value="Envoi lien de modification" />
            </div>
        </form>
    </div>
</main>
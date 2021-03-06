<main>
    <h1>Se connecter</h1>
    <div class="connexion">
        <form method="post" action="index.php?page=connexion">
            <div class="champ positionText">
                <label for="mail"></label>
                <div class="group-pass">
                    <input class="textconnexion" type="email" id="mail" name="mail" placeholder="Adresse Mail" required
                        pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" />
                </div>
            </div>
            <div class="champ positionText">
                <label for="pass"></label>
                <div class="group-pass">
                    <input class="textconnexion" type="password" id="pass" name="pass" placeholder="Mot de passe"
                        required />
                    <div class="imgPassword">
                        <img id="eye" src="./public/medias/eye.svg" alt="afficher mot de passe" onclick="affiche()">
                    </div>
                </div>
            </div>
            <!--bouton d'envoi du formulaire-->
            <div class="champ" id="button">
                <input class="btnconnexion" type="submit" value="Se connecter" />
            </div>
            <a href="#" onclick="redirection()">Mot de passe oublié ?</a>
        </form>
    </div>
</main>
<script>
function redirection() {
    const mailNameVal = $('#mail').val();
    window.location.href = "index.php?page=mdpoublie&mail=" + mailNameVal;
}
</script>
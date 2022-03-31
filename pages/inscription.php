<!-- formulaire permettant de créer un nouvel identifiant-->
<main>
    <h1>S'inscrire</h1>
    <div class="inscription">
        <form method="post" action="index.php?page=register">
            <div class="champ positionText">
                <label for="firstname"></label>
                <input class="textinscription" type="text" id="firstname" name="firstname" placeholder="Prenom" />
            </div>
            <div class="champ positionText">
                <label for="name"></label>
                <input class="textinscription" type="text" id="name" name="name" placeholder="Nom" />
            </div>
            <div class="champ positionText">
                <label for="mail"></label>
                <input class="textinscription" type="email" id="mail" name="mail" placeholder="Adresse Mail" required
                    pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" />
            </div>
            <div class="champ positionText">
                <label for="mobile"></label>
                <input class="textinscription" type="mobile" id="phone" name="phone" placeholder="N° de Téléphone" />
            </div>
            <div class="champ positionText">
                <label for="pass"></label>
                <input class="textinscription" type="password" id="pass" name="pass" placeholder="Mot de passe"
                    required />
            </div>
            <div class="champ positionText">
                <label for="pass"></label>
                <input class="textinscription" type="password" id="pass" name="pass"
                    placeholder="Confirmation Mot de passe" required />
            </div>
            <div class="champ positionText">
                <label for="patient">Patient cabinet:</label>
                <input type="radio" id="patient" name="id_groupe_utilisateur" value="1" />
            </div>
            <div class="champ positionText">
                <label for="Pro">Professionnel :</label>
                <input type="radio" id="pro" name="id_groupe_utilisateur" value="2" />
            </div>
            <div class="champ positionText">
                <label for="Autre">Autre :</label>
                <input type="radio" id="autre" name="id_groupe_utilisateur" value="3" />
            </div>
            <!-- <div class="champ positionText">
                <label for="Admin">Admin :</label>
                <input type="radio" id="autre" name="id_groupe_utilisateur" value="4" />
            </div> -->
            <div class="champ infoValid">
                <label for="downloadValid">En cochant cette case vous acceptez que les informations sur
                    vos téléchargements soient récupérées:</label>
                <input type="checkbox" id="check" name="downloadValid" value="1" required />
            </div>
            <!--bouton d'envoi du formulaire-->
            <div class="champ" id="button">
                <input class="btninscription" type="submit" value="S'inscrire" name="register" />
            </div>
            <!--bouton de validation de la prise d'information sur les téléchargements-->
        </form>
    </div>
</main>
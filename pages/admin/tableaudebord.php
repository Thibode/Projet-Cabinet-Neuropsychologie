<head>
    <title>Tableau de bord - Administrateur</title>
    <link rel="stylesheet" href="./public/CSS/todolist.css">
    <link rel="stylesheet" href="./public/CSS/tableaudebord.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"
        integrity="sha512-yFjZbTYRCJodnuyGlsKamNE/LlEaEAxSUDe5+u61mV8zzqJVFOH7TnULE2/PP/l5vKWpUNnF4VGVkXh3MjgLsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="fullcalendar/main.css">
    <script src="fullcalendar/main.js"></script>

</head>

<body>
    <h1>Bienvenue sur votre tableau de bord.</h1>

    <h3 id="addEvent" class="text-center" style="cursor:pointer;">Ajouter un rendez vous</h3>
    <div class="alignElement">
        <div class="emplacement">
            <div id="calendrier"></div>
            <!--MODAL qui s'affiche lorsque l'on clique sur le bouton ajouter un rdv-->
            <div id="calendarModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modalTitle" class="modal-title">Ajouter un rendez-vous :</h4>
                        </div>
                        <div id="modalBody" class="modal-body">
                            <label for="patient-select">Nom Patient:</label>
                            <select name="patient" id="patientId">
                                <option value=""></option>
                                <?php
                                include('utils/db.php');

                                $stmt = $pdo->prepare("SELECT id_utilisateur, nom_utilisateur FROM utilisateurs WHERE id_groupe_utilisateur = 1");
                                $stmt->execute();
                                $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($liste as $listePatient) {

                                    echo "<option value='" . $listePatient['id_utilisateur'] . "'>" . $listePatient['nom_utilisateur'] . "</option>";
                                }

                                ?>

                            </select><br>
                            <label for="libelle-rdv">Titre du rendez-vous:</label>
                            <input type="text" name="libelle" id="libelleRdv"><br>
                            <label for="start-rdv">Début du rendez-vous:</label>
                            <input type="datetime-local" name="start" id="debutRdv"><br>
                            <label for="end-rdv">Fin du rendez-vous:</label>
                            <input type="datetime-local" name="end" id="finRdv"><br>
                            <label for="remarque-rdv">Remarque:</label>
                            <textarea name="description" id="remarqueRdv" cols="30" rows="10"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                id="btn-valid">Valider</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--MODAL qui s'affiche lorsque l'on clique sur le calendrier-->
            <div id="calendarModal-editEvent" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modalTitle" class="modal-title">Modifier un rendez-vous :</h4>
                        </div>
                        <div id="modalBody" class="modal-body">
                            <label for="patient-select">Nom Patient:</label>
                            <select name="patient" id="patientId">
                                <option value=""></option>
                            </select><br>
                            <label for="libelle-rdv">Titre du rendez-vous:</label>
                            <input type="text" name="libelle" id="libelleRdv"
                                value="<?php echo $value['libelle_rdv'] ?>"><br>
                            <label for="start-rdv">Début du rendez-vous:</label>
                            <input type="datetime-local" name="start" id="debutRdv"><br>
                            <label for="end-rdv">Fin du rendez-vous:</label>
                            <input type="datetime-local" name="end" id="finRdv"><br>
                            <label for="remarque-rdv">Remarque:</label>
                            <textarea name="description" id="remarqueRdv" cols="30" rows="10"></textarea>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="modif"><img src="./public/medias/pen.svg"></a>
                            <a href="#" id="suppr"><img src="./public/medias/trash.svg"></a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                id="btn-valid">Valider</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="separation"></div>

        <div class="emplacement2">
            <div id='todolist-container'>
                <form class="todolist-form">
                    <h2 class="titreTodo">Liste de tâches:</h2>
                    <input type="text" class="todo-input">
                    <div class="ligne2">
                        <button class="todo-button" type="submit">
                            <em class="fas fa-plus-square"></em>
                        </button>
                        <div class="select">
                            <select name="todos" class="filter-todo">
                                <option value="all">Toutes</option>
                                <option value="completed">Complétée</option>
                                <option value="uncompleted">A Faire</option>
                            </select>
                        </div>
                    </div>
                    <div class="todo-container">
                        <ul class="todo-list"></ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="public/JS/todolist.js"></script>
    <script src="public/JS/calendrier.js"></script>
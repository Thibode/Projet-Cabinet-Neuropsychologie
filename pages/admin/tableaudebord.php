<head>
    <meta charset='utf-8' />
    <link href='fullcalendar/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="./public/CSS/todolist.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"
        integrity="sha512-yFjZbTYRCJodnuyGlsKamNE/LlEaEAxSUDe5+u61mV8zzqJVFOH7TnULE2/PP/l5vKWpUNnF4VGVkXh3MjgLsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
    <link rel="stylesheet" href="./public/CSS/tableaudebord.css">
    <script src='fullcalendar/main.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
    </script>

</head>

<body>
    <h1>Bienvenue sur votre tableau de bord.</h1>
    <div class="alignElement">
        <div class="emplacement">
            <div id='calendar'></div>
        </div>
        <div class="info">
            <div class="visit"></div>
            <div class="exodl"></div>
            <div class="newuser"></div>
        </div>
        <div class="emplacement2">
            <div id='todolist-container'>
                <form class="todolist-form">
                    <h2 class="titreTodo">Liste de tâches:</h2>
                    <input type="text" class="todo-input">
                    <div class="ligne2">
                        <button class="todo-button" type="submit">
                            <i class="fas fa-plus-square"></i>
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
    <script src="./public/JS/todolist.js"></script>
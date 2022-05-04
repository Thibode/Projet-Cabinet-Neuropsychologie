document.addEventListener("DOMContentLoaded", function () {
  var elementCalendrier = document.getElementById("calendrier");
  // J'instancie le calendrier
  var calendrier = new FullCalendar.Calendar(elementCalendrier, {
    //On appelle les composants
    initialView: "timeGridWeek",
    slotMinTime: "08:00",
    slotMaxTime: "20:00",
    locale: "fr",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,list",
    },
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week: "Semaine",
      list: "Liste",
    },
    weekends: false,
    nowIndicator: true,
    editable: true,
    eventDrop: (infos) => {
      if (!confirm("Etes vous sûre de vouloir déplacer cet évènement ?")) {
        infos.revert();
      }
    },
    eventResize: (infos) => {
      console.log(infos.event.end);
    },
    events: {
      url: "request/listEventsCalendar.php",
    },
    eventClick: function (info) {
      $("#calendarModal-editEvent").modal("toggle");
    },
  });
  calendrier.render();
});

$("#addEvent").on("click", function () {
  $("#calendarModal").modal("toggle");
  $("#btn-valid").click(function () {
    const patientId = $("#patientId").val();
    const libelleRdv = $("#libelleRdv").val();
    const debRdv = $("#debutRdv").val();
    const finRdv = $("#finRdv").val();
    const remarqueRdv = $("#remarqueRdv").val();
    $.ajax({
      type: "POST",
      url: "index.php?page=admin/insertRdv",
      data: {
        postpatientId: patientId,
        postlibelleRdv: libelleRdv,
        postdebRdv: debRdv,
        postfinRdv: finRdv,
        postremarqueRdv: remarqueRdv,
      },
      success: function () {
        console.log(patientId);
      },
    });
  });
});

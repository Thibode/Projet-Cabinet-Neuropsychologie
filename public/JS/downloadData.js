$(document).ready(function () {
  $(document).on("click", "a[data-role=envoiData]", function () {
    const idPdf = $(this).data("id");
    const idSession = $("td").children("input[data-target=idSession]").val();
    $.ajax({
      type: "POST",
      url: "index.php?page=profil/telechargement",
      data: {
        envoiIdPdf: idPdf,
        envoiIdSession: idSession,
      },
      success: function (response) {},
    });
  });
});

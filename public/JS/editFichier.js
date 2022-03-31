$(document).ready(function () {
  $(document).on("click", "button[data-role=update]", function () {
    // Lorsqu'on click sur le button on récupère les différentes informations sur les fichiers par rapport à l'id du pdf
    const id = $(this).data("id");
    const libelle = $("#" + id)
      .children("td[data-target=libelle]")
      .text();
    const description = $("#" + id)
      .children("td[data-target=description]")
      .text();
    //En dessous chaque id de ma modal sont associés au différentes valeurs récupérée ci dessus
    $("#editModal").modal("toggle");
    $("#libelleEdit").val(libelle);
    $("#descEdit").val(description);
    $("#idpdf").val(id);
  });
  //Lorsqu'on click sur editInfo on prend les valeurs rentrées dans chaque champs et on les associes
  $("#editInfo").click(function () {
    const id = $("#idpdf").val();
    const libelleEdit = $("#libelleEdit").val();
    const descEdit = $("#descEdit").val();
    $.ajax({
      type: "POST",
      url: "index.php?page=admin/envoiFichier",
      data: {
        postEditId: id,
        postLibelle: libelleEdit,
        postDescription: descEdit,
      },
      success: function (response) {
        $("#editModal").modal("toggle");
        $("#" + id)
          .children("td[data-target=libelle]")
          .text(libelleEdit);
        $("#" + id)
          .children("td[data-target=description]")
          .text(descEdit);
      },
    });
  });
});

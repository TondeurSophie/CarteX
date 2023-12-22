$(document).ready(function () {
    $(".supprimer-carte").on("click", function () {
        var idCarte = $(this).data("id");

        //Confirmer la suppression 
        if (confirm("Voulez-vous vraiment supprimer cette carte?")) {
            //Requête AJAX pour supprimer la carte
            $.ajax({
                type: "POST",
                url: "supprimerCarte.php",
                data: { id_carte: idCarte },
                success: function (response) {
                    //Rafraîchir la page après la suppression
                    location.reload();
                },
                error: function (error) {
                    console.log("Erreur lors de la suppression de la carte: " + error);
                }
            });
        }
    });
});
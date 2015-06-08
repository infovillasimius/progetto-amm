$(document).ready(function () {

    $("#richiedente").focusin(function (event) {
        rich = true;
        event.preventDefault();
        $("div.right").hide("slow");
        $("div.none").show("slow");

    });

    $("#procuratore").focusin(function (event) {
        rich = false;
        event.preventDefault();
        $("div.right").hide("slow");
        $("div.none").show("slow");

    });

    $("#salvaAn").click(function (event) {
        event.preventDefault();
        idAn = $("#idAn").val();
        if (idAn === "") {
            alert("Errore: nessuna anagrafica selezionata");
        } else {
            if (rich === true) {
                changeRich();
            } else {
                changeProc();
            }
            $("div.none").hide("slow");
            $("div.right").show("slow");
        }
    });

    $("#cerca").click(function (event) {
        event.preventDefault();
        var nomeAn = $("#nomeAn:text").val();

        var cognomeAn = $("#cognomeAn:text").val();
        var contattoAn = $("#contattoAn:text").val();

        if (nomeAn !== "" && cognomeAn !== "" ) {
            $.ajax({
                url: "index.php",
                data: {
                    page: "operatore",
                    cmd: "cercaAn",
                    nome: nomeAn,
                    cognome: cognomeAn,
                    contatto: contattoAn
                },
                type: "POST",
                dataType: 'json',
                success: function (data, state) {
                    $("#result").text("Trovato: "+ data.nomeAn + " "+ data.cognomeAn + " " + data.contattoAn)
                    $("#result").show("slow");
//                    $("#nomeAn").val(data.nomeAn);
//                    $("#cognomeAn").val(data.cognomeAn);
//                    $("#contattoAn").val(data.contattoAn);
                    $("#idAn").val(data.idAn);

                },
                error: function (data, status, errorThrown) {

                }
            });
        } else {
            alert("Compilare tutti i campi");
        }

    });





    function changeRich() {
        $("#richiedente").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#richiedenteId").val($("idAn").val());
    }

    function changeProc() {
        $("#procuratore").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#procuratoreId").val($("idAn").val());
        $("#contatto").val($("#contattoAn").val());
    }

    $("#chiudi").click(function (event) {
        event.preventDefault();

        $("div.none").hide("slow");
        $("div.right").show("slow");

    });


});




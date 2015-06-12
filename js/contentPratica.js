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
            $("#nomeAn").val("");
            $("#cognomeAn").val("");
            $("#contattoAn").val("");
            $("#idAn").val("");
            $("#result").hide("slow");
            $("div.none").hide("slow");
            $("div.right").show("slow");
        }
    });

    $("#cerca").click(function (event) {
        event.preventDefault();
        var nomeAn = $("#nomeAn:text").val();
        var cognomeAn = $("#cognomeAn:text").val();
        var contattoAn = $("#contattoAn:text").val();

        if (nomeAn !== "" && cognomeAn !== "") {
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
                    $("#result").text("Trovato: " + data.nomeAn + " " + data.cognomeAn + "\n " + data.contattoAn)
                    $("#result").show("slow");
                    $("#idAn").val(data.idAn);
                    contatto = data.contattoAn;
                    idAn = data.idAn;

                },
                error: function (data, status, errorThrown) {
                    alert("Errore di ricezione dati dal server");
                }
            });
        } else {
            alert("Compilare i campi [nome] e [cognome]");
        }

    });

    function changeRich() {
        $("#richiedente").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#richiedenteId").attr("value", idAn);
    }

    function changeProc() {
        $("#procuratore").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#procuratoreId").attr("value", idAn);
        $("#contatto").attr("value", contatto);
        $("#contatto").val(contatto);
    }

    $("#chiudi").click(function (event) {
        event.preventDefault();

        $("div.none").hide("slow");
        $("div.right").show("slow");

    });

    $("#salva").click(function (event) {
        incaricato = $("#incaricato").val();
        numeroPratica = $("#numeroPratica").val();
        numeroProtocollo = $("#numeroProtocollo").val();
        procuratoreId = $("#procuratoreId").val();
        richiedenteId = $("#richiedenteId").val();
        statoPratica = $("#statoPratica").val();
        tipoPratica = $("#tipoPratica").val();
        if (incaricato=="" || incaricato < 1 || numeroPratica == "" || numeroProtocollo == "" ||
                procuratoreId == "" || richiedenteId == "" || statoPratica<1 || 
                statoPratica == "" || tipoPratica == "" || tipoPratica<1) {
            event.preventDefault();
            if (incaricato < 1 || incaricato=="") {
                $("#incaricato").addClass("error");
            }
            if (numeroPratica == "") {
                $("#numeroPratica").addClass("error");
            }
            if(numeroProtocollo ==""){$("#numeroProtocollo").addClass("error");}
            if(procuratoreId == ""){$("#procuratore").addClass("error");}
            if(richiedenteId == ""){$("#richiedente").addClass("error");}
            if(statoPratica == "" || statoPratica <1){$("#statoPratica").addClass("error");}
            if(tipoPratica == "" || tipoPratica<1){$("#tipoPratica").addClass("error");}
            alert("Errore: occorre compilare almeno i campi evidenziati");

        }
    });


});




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

    $("#assegna").click(function (event) {
        event.preventDefault();
        idAn = $("#idAn").val();
        contatto = $("#contattoAn").val();
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
            $("#ricerca").val("");
            $("#idAn").val("");
            $("#result").hide("slow");
            $("div.none").hide("slow");
            $("div.right").show("slow");
        }
    });

    $("#salvaAn").click(function (event) {
        event.preventDefault();
        var nomeAn = $("#nomeAn:text").val();
        var cognomeAn = $("#cognomeAn:text").val();
        var contattoAn = $("#contattoAn:text").val();
        var tipo = $('select#tipo option:selected').attr('value');
        var id = $("#idAn").val();
        alert(id);

        if ((nomeAn !== "" && cognomeAn !== "" && tipo == 0) || (cognomeAn !== "" && tipo == 1)) {
            $.ajax({
                url: "index.php",
                data: {
                    page: "operatore",
                    cmd: "cercaAn",
                    tipo: tipo,
                    nome: nomeAn,
                    cognome: cognomeAn,
                    contatto: contattoAn,
                    id: id
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
            if (tipo == 0) {
                alert("Compilare i campi [nome] e [cognome]");
            } else {
                alert("Compilare il campo [ragione sociale]");
            }

        }
        $("#lista").html("");
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
        if (incaricato == "" || incaricato < 1 || numeroPratica == "" || numeroProtocollo == "" ||
                procuratoreId == "" || richiedenteId == "" || statoPratica < 1 ||
                statoPratica == "" || tipoPratica == "" || tipoPratica < 1) {
            event.preventDefault();
            if (incaricato < 1 || incaricato == "") {
                $("#incaricato").addClass("error");
            }
            if (numeroPratica == "") {
                $("#numeroPratica").addClass("error");
            }
            if (numeroProtocollo == "") {
                $("#numeroProtocollo").addClass("error");
            }
            if (procuratoreId == "") {
                $("#procuratore").addClass("error");
            }
            if (richiedenteId == "") {
                $("#richiedente").addClass("error");
            }
            if (statoPratica == "" || statoPratica < 1) {
                $("#statoPratica").addClass("error");
            }
            if (tipoPratica == "" || tipoPratica < 1) {
                $("#tipoPratica").addClass("error");
            }
            alert("Errore: occorre compilare almeno i campi evidenziati");

        }
    });

    $("select#tipo").change(function (event) {
        tipo = $('select#tipo option:selected').attr('value');

        if (tipo == 1) {
            $(".nomeAn").hide("slow");
            $(".nomeAn").val("");
            $("#lcognome").text("Ragione sociale");

        } else {
            $(".nomeAn").show("slow");
            $("#lcognome").text("Cognome");
        }
    });

    $('#input').keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
        }
    });


    $("#ricerca").keyup(function (event) {
//        var nomeAn = $("#nomeAn:text").val();
        var cognomeAn = $("#ricerca:text").val();

        if (cognomeAn !== "") {
            $.ajax({
                url: "index.php",
                data: {
                    page: "operatore",
                    cmd: "ricercaAn",
//                    nome: nomeAn,
                    cognome: cognomeAn,
                },
                type: "POST",
                dataType: 'json',
                success: function (data, state) {
                    $("#lista").html(data.testo);
                },
                error: function (data, status, errorThrown) {
                    alert("Errore di ricezione dati dal server");
                }
            });
        }
    });

    $("#lista").click(function (event) {
        var id = $('select#lista option:selected').attr('value');

        $.ajax({
            url: "index.php",
            data: {
                page: "operatore",
                cmd: "getAn",
                id: id,
            },
            type: "POST",
            dataType: 'json',
            success: function (data, state) {
                $("#idAn").val(data.id);
                $("#nomeAn:text").val(data.nome);
                $("#cognomeAn:text").val(data.cognome);
                $("#contattoAn:text").val(data.contatto);
                $('select#tipo option').each(function () {
                    if ($(this).val() == data.tipo) {
                        $(this).attr("selected", "selected")
                    }
                });
            },
            error: function (data, status, errorThrown) {
                alert("Errore di ricezione dati dal server");
            }
        });

    });


});


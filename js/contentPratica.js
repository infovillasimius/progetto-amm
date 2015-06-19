$(document).ready(function () {

    /**
     * Visualizza parte pagina relativa alla gestione dell'anagrafica
     * relativa al richiedente, utilizzando una flag per memorizzare
     * che si tratta del richiedente e non del procuratore
     */
    $("#richiedente").focusin(function (event) {
        rich = true;
        event.preventDefault();
        $("div.right").hide("slow");
        $("div.none").show("slow");
    });

    /**
     * Visualizza parte pagina relativa alla gestione dell'anagrafica
     * relativa al procuratore, utilizzando una flag per memorizzare
     * che si tratta del procuratore e non del richiedente
     */
    $("#procuratore").focusin(function (event) {
        rich = false;
        event.preventDefault();
        $("div.right").hide("slow");
        $("div.none").show("slow");
    });

    /**
     * Memorizza alla pressione del pulsante [assegna], il nominativo trovato
     * mediante l'interrogazione del server, sulla casella del nominativo del 
     * richiedente o del procuratore ed il valore dell'id dello stesso, nella 
     * apposta input di tipo hidden
     */
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

    /**
     * Effettua il salvataggio o l'aggiornamento
     * dell'anagrafica inserita
     */
    $("#salvaAn").click(function (event) {
        event.preventDefault();
        var nomeAn = $("#nomeAn:text").val();
        var cognomeAn = $("#cognomeAn:text").val();
        var contattoAn = $("#contattoAn:text").val();
        var tipo = $('select#tipo option:selected').attr('value');
        var id = $("#idAn").val();
        var scelta = true;
        if (id != "") {
            scelta = confirm("Vuoi davvero modificare l'anagrafica?");
        }
        if (scelta === true) {

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
                        $("#result").text("Salvato/aggiornato: " + data.nomeAn + " " + data.cognomeAn + "\n " + data.contattoAn)
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
        }
    });

    /**
     * Effettua l'inserimento del nominativo nella casella del richiedente
     * @returns {undefined}
     */
    function changeRich() {
        $("#richiedente").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#richiedenteId").attr("value", idAn);
    }

    /**
     * Effettua l'inserimento del nominativo e del contatto nella casella del 
     * procuratore e del contatto
     * @returns {undefined}
     */
    function changeProc() {
        $("#procuratore").val($("#nomeAn").val() + " " + $("#cognomeAn").val());
        $("#procuratoreId").attr("value", idAn);
        $("#contatto").attr("value", contatto);
        $("#contatto").val(contatto);
    }

    /**
     * Nasconde la div relativa alla gestione dell'anagrafica
     * e mostra la seconda parte della pagina della gestione pratica
     */
    $("#chiudi").click(function (event) {
        event.preventDefault();
        $("#nomeAn").val("");
        $("#cognomeAn").val("");
        $("#contattoAn").val("");
        $("#ricerca").val("");
        $("#idAn").val("");
        $("#result").hide("slow");
        $("div.none").hide("slow");
        $("div.right").show("slow");

    });

    /**
     * Salva pratica dopo verifica dell'inserimento dei
     * dati obbligatori
     */
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

    /**
     * Modifica i campi della gestione anagrafica affinchè 
     * si adattino alle persone fisiche e a quelle giuridiche
     * nel momento che viene cambiato il valore mostrato dalla
     * select
     */
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

    /**
     * Previene il comportamento di default del tasto invio
     */
    $('#input').keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
        }
    });

    /**
     * Popola la select con le anagrafiche trovate
     */
    $("#ricerca").keyup(function (event) {
        var cognomeAn = $("#ricerca:text").val();

        if (cognomeAn !== "") {
            $.ajax({
                url: "index.php",
                data: {
                    page: "operatore",
                    cmd: "ricercaAn",
                    cognome: cognomeAn
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

    /**
     * Recupera il valore dell'id associato all'anagrafica scelta
     * e lo utilizza per ottenere i dati necessari per compilare 
     * tutti i campi della gestione anagrafica
     */
    $("#lista").click(function (event) {
        var id = $('select#lista option:selected').attr('value');

        if (id !== undefined) {
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
                        (this).remove();
                    });
                    if (data.tipo == 0) {
                        $('select#tipo').html('<option value="0" selected="selected">Persona Fisica</option><option value="1">Persona Giuridica</option>')
                        $(".nomeAn").show("slow");
                        $("#lcognome").text("Cognome");
                    } else {
                        $('select#tipo').html('<option value="0">Persona Fisica</option><option value="1" selected="selected">Persona Giuridica</option>')
                        $(".nomeAn").hide("slow");
                        $(".nomeAn").val("");
                        $("#lcognome").text("Ragione sociale");
                    }

                },
                error: function (data, status, errorThrown) {
                    alert("Errore di ricezione dati dal server");
                }
            });
        }

    });


});


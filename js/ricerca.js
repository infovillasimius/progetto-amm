$(document).ready(function (event) {
    tipocomportamento = -1;
    var numeroPratica = 0;
    var statoPratica = 0;
    var tipoPratica = 0;
    var incaricato = 0;
    var flagAllaFirma = -1;
    var flagFirmata = -1;
    var flagSoprintendenza = -1;
    var flagInAttesa = -1;

    $.ajax({
        url: "index.php",
        data: {
            page: "operatore",
            cmd: "cercaP",
            numeroPratica: numeroPratica,
            statoPratica: statoPratica,
            tipoPratica: tipoPratica,
            incaricato: incaricato,
            flagAllaFirma: flagAllaFirma,
            flagFirmata: flagFirmata,
            flagSoprintendenza: flagSoprintendenza,
            flagInAttesa: flagInAttesa
        },
        type: "POST",
        dataType: 'json',
        success: function (data, state) {

            $("table.result tbody:last").append(data.testo);

        },
        error: function (data, status, errorThrown) {
            alert("Errore di ricezione dati dal server");
        }
    });




    $("table.elencoP").change(function (event) {
        $('table.result tr.a').each(function () {
            $(this).remove();
        });
        $('table.result tr.b').each(function () {
            $(this).remove();
        });

        var numeroPratica = $("#numeroP:text").val();
        var statoPratica = $('select#statoPratica option:selected').attr('value');

        var tipoPratica = $('select#tipoPratica option:selected').attr('value');
        var incaricato = $('select#incaricato option:selected').attr('value');
        var flagAllaFirma = $('#flagAllaFirma:checked').val();
        if (flagAllaFirma == "on") {
            flagAllaFirma = 1;
        } else {
            flagAllaFirma = tipocomportamento;
        }
        var flagFirmata = $('#flagFirmata:checked').val();
        if (flagFirmata == "on") {
            flagFirmata = 1;
        } else {
            flagFirmata = tipocomportamento;
        }
        var flagSoprintendenza = $('#flagSoprintendenza:checked').val();
        if (flagSoprintendenza == "on") {
            flagSoprintendenza = 1;
        } else {
            flagSoprintendenza = tipocomportamento;
        }
        var flagInAttesa = $('#flagInAttesa:checked').val();
        if (flagInAttesa == "on") {
            flagInAttesa = 1;
        } else {
            flagInAttesa = tipocomportamento;
        }
        $.ajax({
            url: "index.php",
            data: {
                page: "operatore",
                cmd: "cercaP",
                numeroPratica: numeroPratica,
                statoPratica: statoPratica,
                tipoPratica: tipoPratica,
                incaricato: incaricato,
                flagAllaFirma: flagAllaFirma,
                flagFirmata: flagFirmata,
                flagSoprintendenza: flagSoprintendenza,
                flagInAttesa: flagInAttesa
            },
            type: "POST",
            dataType: 'json',
            success: function (data, state) {

                $("table.result tbody:last").append(data.testo);

            },
            error: function (data, status, errorThrown) {
                alert("Errore di ricezione dati dal server");
            }
        });


    });

    $("#reset").click(function (event) {
        $('table.result tr.a').each(function () {
            $(this).remove();
        });
        $('table.result tr.b').each(function () {
            $(this).remove();
        });


        var numeroPratica = 0;
        var statoPratica = 0;
        var tipoPratica = 0;
        var incaricato = 0;
        var flagAllaFirma = -1;
        var flagFirmata = -1;
        var flagSoprintendenza = -1;
        var flagInAttesa = -1;
        tipocomportamento = -1;

        $.ajax({
            url: "index.php",
            data: {
                page: "operatore",
                cmd: "cercaP",
                numeroPratica: numeroPratica,
                statoPratica: statoPratica,
                tipoPratica: tipoPratica,
                incaricato: incaricato,
                flagAllaFirma: flagAllaFirma,
                flagFirmata: flagFirmata,
                flagSoprintendenza: flagSoprintendenza,
                flagInAttesa: flagInAttesa
            },
            type: "POST",
            dataType: 'json',
            success: function (data, state) {

                $("table.result tbody:last").append(data.testo);

            },
            error: function (data, status, errorThrown) {
                alert("Errore di ricezione dati dal server");
            }
        });


    });

    $("#change").click(function (event) {
        event.preventDefault();
        tipocomportamento = 0;
    });

    $("#change2").click(function (event) {
        event.preventDefault();
        tipocomportamento = -1;
    });
    
    $("#avanti").click(function (event) {
        event.preventDefault();
        
    });
    
    $("#indietro").click(function (event) {
        event.preventDefault();
        
    });


});

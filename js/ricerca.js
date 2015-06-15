$(document).ready(function (event) {
    tipocomportamento = -1;
    numeroPratica = 0;
    statoPratica = 0;
    tipoPratica = 0;
    incaricato = 0;
    flagAllaFirma = -1;
    flagFirmata = -1;
    flagSoprintendenza = -1;
    flagInAttesa = -1;
    offset = 0;
    numero = 13;
    numeroPratiche = 0;
    numRow = 0;

    interroga();

    $("table.elencoP").change(function (event) {
        $('table.result tr.a').each(function () {
            $(this).remove();
        });
        $('table.result tr.b').each(function () {
            $(this).remove();
        });

        numeroPratica = $("#numeroP:text").val();
        statoPratica = $('select#statoPratica option:selected').attr('value');
        tipoPratica = $('select#tipoPratica option:selected').attr('value');
        incaricato = $('select#incaricato option:selected').attr('value');
        flagAllaFirma = $('#flagAllaFirma:checked').val();

        if (flagAllaFirma == "on") {
            flagAllaFirma = 1;
        } else {
            flagAllaFirma = tipocomportamento;
        }
        flagFirmata = $('#flagFirmata:checked').val();
        if (flagFirmata == "on") {
            flagFirmata = 1;
        } else {
            flagFirmata = tipocomportamento;
        }
        flagSoprintendenza = $('#flagSoprintendenza:checked').val();
        if (flagSoprintendenza == "on") {
            flagSoprintendenza = 1;
        } else {
            flagSoprintendenza = tipocomportamento;
        }
        flagInAttesa = $('#flagInAttesa:checked').val();
        if (flagInAttesa == "on") {
            flagInAttesa = 1;
        } else {
            flagInAttesa = tipocomportamento;
        }
        interroga();

    });

    $("#reset").click(function (event) {

        numeroPratica = 0;
        statoPratica = 0;
        tipoPratica = 0;
        incaricato = 0;
        flagAllaFirma = -1;
        flagFirmata = -1;
        flagSoprintendenza = -1;
        flagInAttesa = -1;
        tipocomportamento = -1;

        interroga();
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
        if (numRow > numero-1) {
            offset += numero;
            if (offset > numeroPratiche) {
                offset = numeroPratiche - numero;
            }
        }
        interroga();

    });

    $("#indietro").click(function (event) {
        event.preventDefault();
        offset -= numero;
        if (offset < 0) {
            offset = 0;
        }
        interroga();
    });


});


function interroga() {

    $('table.result tr.a').each(function () {
        $(this).remove();
    });
    $('table.result tr.b').each(function () {
        $(this).remove();
    });

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
            flagInAttesa: flagInAttesa,
            offset: offset,
            numero: numero
        },
        type: "POST",
        dataType: 'json',
        success: function (data, state) {

            $("table.result tbody:last").append(data.testo);
            numeroPratiche = data.numeroPratiche;
            numRow = data.numRow;

        },
        error: function (data, status, errorThrown) {
            alert("Errore di ricezione dati dal server");
        }
    });
}
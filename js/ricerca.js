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
    numero = 15;
    numeroPratiche = 0;
    numRow = 0;

    interroga();

    /**
     * Previene il comportamento normale del tasto invio
     */
    $('.elencoP').keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
        }
    });

    /**
     * controlla se sono stati modificati i parametri della ricerca
     */
    $("table.elencoP").change(function (event) {
        offset = 0;
        interroga();

    });

    /**
     * Effettua il reset dei parametri di ricerca
     */
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
        offset = 0;
        interroga2();
    });

    /**
     * Imposta il metodo di ricerca che permette di visualizzare le pratiche che
     * hanno i flag attivati o disattivati esattamente come impostato nei parametri
     * di ricerca, come specificato a video
     */
    $("#change").click(function (event) {
        event.preventDefault();
        tipocomportamento = 0;
        interroga();
    });
    
    /**
     * Imposta il metodo di ricerca meno restrittivo, che comporta la visualizzazione 
     * di tutte le pratiche se il flag nella tabella di ricerca non è impostato e delle
     * sole pratiche flaggate se impostato
     */
    $("#change2").click(function (event) {
        event.preventDefault();
        tipocomportamento = -1;
        interroga();
    });

    /**
     * Scorre la tabella delle pratiche in avanti
     */
    $("#avanti").click(function (event) {
        event.preventDefault();
        if (numRow > numero - 1) {
            offset += numero;
            if (offset >= numeroPratiche) {
                offset = numeroPratiche - numero;
            }
        }
        interroga();

    });

    /**
     * Scorre la tabella delle pratiche all'indietro
     */
    $("#indietro").click(function (event) {
        event.preventDefault();
        offset -= numero;
        if (offset < 0) {
            offset = 0;
        }
        interroga();
    });


});

/**
 * Imposta i parametri della ricerca leggendo le impostazioni contenute nella tabella
 * e lancia la interrogazione
 * @returns {undefined}
 */
function interroga() {

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
    interroga2();

}

/**
 * Interroga il server in base alle impostazioni di ricerca memorizzate 
 * @returns {undefined}
 */
function interroga2() {

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
            var tipoRic = (1 + tipocomportamento * (-1));
            var descTipoRic = tipoRic == 1 ? " - Flag disattivo=solo senza" : " - Flag disattivo=tutte";
            $("#pagine").text("Tipo ricerca: " + tipoRic + descTipoRic + " - Pratiche visualizzate: da " + (offset+1) + " a " + (offset+numRow) + " di " + numeroPratiche);

        },
        error: function (data, status, errorThrown) {
            alert("Errore di ricezione dati dal server");
        }
    });


}


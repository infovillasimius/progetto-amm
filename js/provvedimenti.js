$(document).ready(function (event) {

    offset = 0;
    numero = 15;
    numeroProvvedimenti = 0;
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
     * Scorre la tabella delle pratiche in avanti
     */
    $("#avanti").click(function (event) {
        event.preventDefault();
        if (numRow > numero - 1) {
            offset += numero;
            if (offset > numeroProvvedimenti) {
                offset = numeroProvvedimenti - numero;
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
            cmd: "cercaProvvedimenti",           
            offset: offset,
            numero: numero
        },
        type: "POST",
        dataType: 'json',
        success: function (data, state) {

            $("table.result tbody:last").append(data.testo); 
            numeroProvvedimenti=data.numeroProvvedimenti;
            numRow=data.numRow;
        },
        error: function (data, status, errorThrown) {
            alert("Errore di ricezione dati dal server");
        }
    });


}


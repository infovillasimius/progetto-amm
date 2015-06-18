$(document).ready(function (event) {

    tipocomportamento = -1;
    numeroPratica = 0;
    statoPratica = 0;
    tipoPratica = 0;
    incaricato = 0;
    flagAllaFirma = 1;
    flagFirmata = -1;
    flagSoprintendenza = -1;
    flagInAttesa = -1;
    offset = 0;
    numero = 15;
    numeroPratiche = 0;
    numRow = 0;

    interroga();
    
//    $('table.result').click(function(event){
//       event.preventDefault(); 
//    });
        
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
            numero: numero,
            richiestaFirmate: 1
        },
        type: "POST",
        dataType: 'json',
        success: function (data, state) {

            $("table.result tbody:last").append(data.testo);
            numeroPratiche = data.numeroPratiche;
            numRow = data.numRow;
            var tipoRic = (1 + tipocomportamento * (-1));
            var descTipoRic = tipoRic == 1 ? " - Flag disattivo=solo senza" : " - Flag disattivo=tutte";
            //$("#pagine").text("Tipo ricerca: " + tipoRic + descTipoRic + " - Pratiche visualizzate: " + numRow + " di " + numeroPratiche + " totali");

        },
        error: function (data, status, errorThrown) {
            alert("Errore di ricezione dati dal server");
        }
    });


}



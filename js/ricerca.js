$(document).ready(function () {
    $("table.result tbody:last").append('<tr class="a"><td><a href="index.php?page=operatore&cmd=aggiornaP&numeroP=3">3</a></td><td>14.06.2015</td><td>Giulietta Montecchi</td><td>Immediato avvio - 0 gg</td><td>Assegnata a operatore</td><td>Antoniana Pisu</td></tr><tr class="b"><td><a href="index.php?page=operatore&cmd=aggiornaP&numeroP=2">2</a></td><td>13.06.2015</td><td>uno qualunque</td><td>Conferenza di Servizi</td><td>Assegnata a operatore</td><td>Giuseppe Rocca</td></tr><tr class="a"><td><a href="index.php?page=operatore&cmd=aggiornaP&numeroP=1">1</a></td><td>12.06.2015</td><td>Angelo Puddu</td><td>Immediato avvio - 0 gg</td><td>Caricata su Sardegna Suap</td><td>Tiziana Utzeri</td></tr>');
    var numeroP = 0;
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
            numeroP: numeroP,
            statoPratica: statoPratica,
            tipoPratica: tipoPratica,
            incaricato: incaricato,
            flagAllaFirma: flagAllaFirma,
            flagFirmata: flagFirmata,
            flagSoprintendenza: flagSoprintendenza,
            flagInAttesa: flagInAttesa
        },
        type: "POST",
        dataType: 'html',
        success: function (data, state) {
            
            $("table.result tbody:last").append(data.html());

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

        var numeroP = $("#numeroP:text").val();
        var statoPratica = $('select#statoPratica option:selected').attr('value');
        var tipoPratica = $('select#tipoPratica option:selected').attr('value');
        var incaricato = $('select#incaricato option:selected').attr('value');
        var flagAllaFirma = $('checkbox#flagAllaFirma').attr('checked') == "checked";
        var flagFirmata = $('checkbox#flagFirmata').attr('checked') == "checked";
        var flagSoprintendenza = $('checkbox#flagSoprintendenza').attr('checked') == "checked";
        var flagInAttesa = ($('checkbox#flagInAttesa').attr('checked') == "checked");

        alert("ajax");
        $.ajax({
            url: "index.php",
            data: {
                page: "operatore",
                cmd: "cercaP",
                numeroP: numeroP,
                statoPratica: statoPratica,
                tipoPratica: tipoPratica,
                incaricato: incaricato,
                flagAllaFirma: flagAllaFirma,
                flagFirmata: flagFirmata,
                flagSoprintendenza: flagSoprintendenza,
                flagInAttesa: flagInAttesa
            },
            type: "POST",
            dataType: 'text',
            success: function (data, state) {
                alert(data);
                $("table.result tbody:last").append(data.text());

            },
            error: function (data, status, errorThrown) {
                alert("Errore di ricezione dati dal server");
            }
        });


    });





});

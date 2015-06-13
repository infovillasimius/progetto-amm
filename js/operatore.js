$(document).ready(function () {

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







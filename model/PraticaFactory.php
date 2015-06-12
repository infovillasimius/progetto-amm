<?php

include_once './model/Pratica.php';

class PraticaFactory {

    public static function salvaP($pratica) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
        }

        //$id = $pratica->getId();
        $contatto = $pratica->getContatto();
        $dataAvvioProcedimento = $pratica->getDataAvvioProcedimento(false);
        $dataCaricamento = $pratica->getDataCaricamento(false);
        $dataConferenzaServizi = $pratica->getDataConferenzaServizi(false);
        $dataInvioRicevuta = $pratica->getDataInvioRicevuta(false);
        $dataInvioVerifiche = $pratica->getDataInvioVerifiche(false);
        $dataProtocollo = $pratica->getDataProtocollo(false);
        $dataProvvedimento = $pratica->getDataProvvedimento(false);
        $flagAllaFirma = $pratica->getFlagAllaFirma();
        $flagFirmata = $pratica->getFlagFirmata();
        $flagInAttesa = $pratica->getFlagInAttesa();
        $flagSoprintendenza = $pratica->getFlagSoprintendenza();
        $importoDiritti = $pratica->getImportoDiritti();
        $incaricato = $pratica->getIncaricato();
        $motivoAttesa = $pratica->getMotivoAttesa();
        $numeroPratica = $pratica->getNumeroPratica();
        $numeroProtocollo = $pratica->getNumeroProtocollo();
        $numeroProtocolloProvvedimento = $pratica->getNumeroProtocolloProvvedimento();
        $oggetto = $pratica->getOggetto();
        $procuratore = $pratica->getProcuratore();
        $procuratoreId = $pratica->getProcuratoreId();
        $richiedente = $pratica->getRichiedente();
        $richiedenteId = $pratica->getRichiedenteId();
        $statoPratica = $pratica->getStatoPratica();
        $tipoPratica = $pratica->getTipoPratica();
        $ubicazione = $pratica->getUbicazione();

//        echo "1 " . $contatto .
//        "<br/> 2 " . $dataAvvioProcedimento .
//        "<br/> 3 " . $dataCaricamento .
//        "<br/> 4 " . $dataConferenzaServizi .
//        "<br/> 5 " . $dataInvioRicevuta .
//        "<br/> 6 " . $dataInvioVerifiche .
//        "<br/> 7 " . $dataProtocollo .
//        "<br/> 8 " . $dataProvvedimento .
//        "<br/> 9 " . $flagAllaFirma .
//        "<br/> 10 " . $flagFirmata .
//        "<br/> 11 " . $flagInAttesa .
//        "<br/> 12 " . $flagSoprintendenza .
//        "<br/> 13 " . $importoDiritti .
//        "<br/> 14 " . $incaricato .
//        "<br/> 15 " . $motivoAttesa .
//        "<br/> 16 " . $numeroPratica .        
//        "<br/> 17 " . $numeroProtocollo .
//        "<br/> 18 " . $numeroProtocolloProvvedimento .
//        "<br/> 19 " . $oggetto .
//        "<br/> 20 " . $procuratoreId .
//        "<br/> 21 " . $richiedenteId .
//        "<br/> 22 " . $statoPratica .
//        "<br/> 23 " . $tipoPratica .
//        "<br/> 24 " . $ubicazione.
//        "<br/> 25 " . $richiedente.
//        "<br/> 26 " . $procuratore;

        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO pratica (id, contatto, dataAvvioProcedimento, dataCaricamento, dataConferenzaServizi, "
                . "dataInvioRicevuta, dataInvioVerifiche, dataProtocollo, dataProvvedimento, flagAllaFirma, "
                . "flagFirmata, flagInAttesa, flagSoprintendenza, importoDiritti, incaricato, motivoAttesa, "
                . "numeroPratica, numeroProtocollo, numeroProtocolloProvvedimento, oggetto, procuratore, "
                . "richiedente, statoPratica, tipoPratica, ubicazione) VALUES (default, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiis", $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione);

        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $stmt->close();
            $mysqli->close();
            echo $errore;
            return $errore;
        } else {
            $stmt->close();
            $mysqli->close();
            return 0;
        }
    }

    public static function getPraticaById($idPratica) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $query="SELECT * FROM pratica JOIN anagrafica ON richiedente=anagrafica.id JOIN anagrafica an2 ON procuratore=an2.id WHERE pratica.id=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $idPratica);
        
        $result = $stmt->execute();
        $stmt->bind_result($id,$contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione,$idRichiedente,$nomeRichiedente,$cognomeRichiedente,$contattoRichiedente,$idProcuratore,$nomeProcuratore,$cognomeProcuratore,$contattoProcuratore);
        
        
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore=$mysqli->errno;
            $mysqli->close();
        } else{
            $stmt->fetch();
            $pratica=new Pratica();
            $pratica->setContatto($contatto);
            $pratica->setDataAvvioProcedimento($dataAvvioProcedimento);
            $pratica->setDataCaricamento($dataCaricamento);
            $pratica->setDataConferenzaServizi($dataConferenzaServizi);
            $pratica->setDataInvioRicevuta($dataInvioRicevuta);
            $pratica->setDataInvioVerifiche($dataInvioVerifiche);
            $pratica->setDataProtocollo($dataProtocollo);
            $pratica->setDataProvvedimento($dataProvvedimento);
            $pratica->setFlagAllaFirma($flagAllaFirma);
            $pratica->setFlagFirmata($flagFirmata);
            $pratica->setFlagInAttesa($flagInAttesa);
            $pratica->setFlagSoprintendenza($flagSoprintendenza);
            $pratica->setImportoDiritti($importoDiritti);
            $pratica->setIncaricato($incaricato);
            $pratica->setMotivoAttesa($motivoAttesa);
            $pratica->setNumeroPratica($numeroPratica);
            $pratica->setNumeroProtocollo($numeroProtocollo);
            $pratica->setNumeroProtocolloProvvedimento($numeroProtocolloProvvedimento);
            $pratica->setOggetto($oggetto);
            $pratica->setProcuratore($nomeProcuratore . " " . $cognomeProcuratore);
            $pratica->setProcuratoreId($procuratoreId);
            $pratica->setRichiedente($nomeRichiedente . " " . $cognomeRichiedente);
            $pratica->setRichiedenteId($richiedenteId);
            $pratica->setStatoPratica($statoPratica);
            $pratica->setTipoPratica($tipoPratica);
            $pratica->setUbicazione($ubicazione);
            return $pratica;
        }
    }

    public static function elencoP($ricerca, $offset, $numero, $ordinamento) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        
        $numeroParametriRicerca=count($ricerca);

        $query = "SELECT operatore.id, anagrafica.nome, anagrafica.cognome, anagrafica.contatto, operatore.funzione, operatore.username, operatore.password, operatore.id_anagrafica FROM anagrafica inner join operatore on anagrafica.id=operatore.id_anagrafica";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
            return null;
        } else {
            $operatori = array();
            while ($row = $result->fetch_object()) {
                $operatore = new Operatore;
                $operatore->setNominativo($row->nome, $row->cognome);
                $operatore->setContatto($row->contatto);
                $operatore->setFunzione($row->funzione);
                $operatore->setUsername($row->username);
                $operatore->setPassword($row->password);
                $operatore->setId($row->id);
                $operatore->setIdAn($row->id_anagrafica);
                $operatori[] = $operatore;
            }
            $mysqli->close();
            return $operatori;
        }
    }

    public static function aggiornaP($pratica) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
        }

        $id = $pratica->getId();
        $contatto = $pratica->getContatto();
        $dataAvvioProcedimento = $pratica->getDataAvvioProcedimento(false);
        $dataCaricamento = $pratica->getDataCaricamento(false);
        $dataConferenzaServizi = $pratica->getDataConferenzaServizi(false);
        $dataInvioRicevuta = $pratica->getDataInvioRicevuta(false);
        $dataInvioVerifiche = $pratica->getDataInvioVerifiche(false);
        $dataProtocollo = $pratica->getDataProtocollo(false);
        $dataProvvedimento = $pratica->getDataProvvedimento(false);
        $flagAllaFirma = $pratica->getFlagAllaFirma();
        $flagFirmata = $pratica->getFlagFirmata();
        $flagInAttesa = $pratica->getFlagInAttesa();
        $flagSoprintendenza = $pratica->getFlagSoprintendenza();
        $importoDiritti = $pratica->getImportoDiritti();
        $incaricato = $pratica->getIncaricato();
        $motivoAttesa = $pratica->getMotivoAttesa();
        $numeroPratica = $pratica->getNumeroPratica();
        $numeroProtocollo = $pratica->getNumeroProtocollo();
        $numeroProtocolloProvvedimento = $pratica->getNumeroProtocolloProvvedimento();
        $oggetto = $pratica->getOggetto();
        //$procuratore = $pratica->getProcuratore();
        $procuratoreId = $pratica->getProcuratoreId();
        //$richiedente = $pratica->getRichiedente();
        $richiedenteId = $pratica->getRichiedenteId();
        $statoPratica = $pratica->getStatoPratica();
        $tipoPratica = $pratica->getTipoPratica();
        $ubicazione = $pratica->getUbicazione();
        
        $stmt = $mysqli->stmt_init();
        $query = "UPDATE pratica SET contatto=?, dataAvvioProcedimento=?, dataCaricamento=?, dataConferenzaServizi=?, "
                . "dataInvioRicevuta=?, dataInvioVerifiche=?, dataProtocollo=?, dataProvvedimento=?, flagAllaFirma=?, "
                . "flagFirmata=?, flagInAttesa=?, flagSoprintendenza=?, importoDiritti=?, incaricato=?, motivoAttesa=?, "
                . "numeroPratica=?, numeroProtocollo=?, numeroProtocolloProvvedimento=?, oggetto=?, procuratore=?, "
                . "richiedente=?, statoPratica=?, tipoPratica=?, ubicazione=?) WHERE id=? ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiisi", $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione,$id);

        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $stmt->close();
            $mysqli->close();
            echo $errore;
            return $errore;
        } else {
            $stmt->close();
            $mysqli->close();
            return 0;
        }
    }

}

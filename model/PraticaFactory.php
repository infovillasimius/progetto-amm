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
        $dataAvvioProcedimento = $pratica->getDataAvvioProcedimento();
        $dataCaricamento = $pratica->getDataCaricamento();
        $dataConferenzaServizi = $pratica->getDataConferenzaServizi();
        $dataInvioRicevuta = $pratica->getDataInvioRicevuta();
        $dataInvioVerifiche = $pratica->getDataInvioVerifiche();
        $dataProtocollo = $pratica->getDataProtocollo();
        $dataProvvedimento = $pratica->getDataProvvedimento();
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
        $query = "INSERT INTO pratica (id, contatto, dataAvvioProcedimento, dataCaricamento, dataConferenzaServizi, "
                . "dataInvioRicevuta, dataInvioVerifiche, dataProtocollo, dataProvvedimento, flagAllaFirma, "
                . "flagFirmata, flagInAttesa, flagSoprintendenza, importoDiritti, incaricato, motivoAttesa, "
                . "numeroPratica, numeroProtocollo, numeroProtocolloProvvedimento, oggetto, procuratore, "
                . "richiedente, statoPratica, tipoPratica, ubicazione) VALUES (default, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiis", $contatto, $dataAvvioProcedimento,
                $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, 
                $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, 
                $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, 
                $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, 
                $richiedenteId, $statoPratica, $tipoPratica, $ubicazione);
        
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $stmt->close();
            $mysqli->close();
            return $errore;
        } else {
            $mysqli->commit();
            $mysqli->autocommit(true);
            $mysqli->close();
            return 0;
        }
    }

    public static function getPraticaById($id) {
        
    }

    public static function elencoP($ricerca, $offset, $numero, $ordinamento) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $query = "SELECT operatore.id, anagrafica.nome, anagrafica.cognome, anagrafica.contatto, operatore.funzione, operatore.username, operatore.password, operatore.id_anagrafica FROM anagrafica inner join operatore on anagrafica.id=operatore.id_anagrafica";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
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

    public static function updateP($pratica) {
        
    }

}

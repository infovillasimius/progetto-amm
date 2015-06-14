<?php

include_once './model/Pratica.php';

class PraticaFactory {

    public static function salvaP($pratica) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
        }

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
        $query = "SELECT pratica.id, pratica.contatto, date_format(dataAvvioProcedimento,'%d/%m/%Y') dataAvvioProcedimento,"
                . "date_format(dataCaricamento,'%d/%m/%Y') dataCaricamento, "
                . "date_format(dataConferenzaServizi,'%d/%m/%Y') dataConferenzaServizi, "
                . "date_format(dataInvioRicevuta,'%d/%m/%Y') dataInvioRicevuta, "
                . "date_format(dataInvioVerifiche,'%d/%m/%Y') dataInvioVerifiche, "
                . "date_format(dataProtocollo,'%d/%m/%Y') dataProtocollo, "
                . "date_format(dataProvvedimento,'%d/%m/%Y') dataProvvedimento, flagAllaFirma, flagFirmata, "
                . "flagInAttesa, flagSoprintendenza, importoDiritti, incaricato, motivoAttesa, numeroPratica, "
                . "numeroProtocollo, numeroProtocolloProvvedimento, oggetto, procuratore, richiedente, "
                . "statoPratica, tipoPratica, ubicazione, anagrafica.nome, anagrafica.cognome, "
                . "anagrafica.contatto, an2.nome, an2.cognome, an2.contatto "
                . "FROM pratica JOIN anagrafica ON richiedente=anagrafica.id JOIN anagrafica an2 ON procuratore=an2.id WHERE pratica.id=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $idPratica);

        $result = $stmt->execute();
        $stmt->bind_result($id, $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione, $nomeRichiedente, $cognomeRichiedente, $contattoRichiedente, $nomeProcuratore, $cognomeProcuratore, $contattoProcuratore);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $stmt->close();
            $mysqli->close();
            return null;
        } else {

            $stmt->fetch();
            $pratica = new Pratica();
            $pratica->setId($id);
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
            $stmt->close();
            $mysqli->close();
            return $pratica;
        }
    }

    /**
     * Esegue una ricerca nelle pratiche
     * @param array associativo $ricerca
     * @param int $offset
     * @param int $numero
     * @param string $ordinamento
     * @return \Pratica
     */
    public static function elencoP($ricerca, $offset, $numero) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $numeroPratica = $ricerca["numeroPratica"];
        $statoPratica = $ricerca["statoPratica"];
        $tipoPratica = $ricerca["tipoPratica"];
        $incaricato = $ricerca["incaricato"];
        $flagAllaFirma = $ricerca["flagAllaFirma"];
        $flagFirmata = $ricerca["flagFirmata"];
        $flagSoprintendenza = $ricerca["flagSoprintendenza"];
        $flagInAttesa = $ricerca["flagInAttesa"];

        $param = array();
        if ($numeroPratica == null || $numeroPratica < 1) {
            $param[0] = ">?";
            $numeroPratica = 0;
        } else {
            $param[0] = "=? ";
        }

        if ($statoPratica == null || $statoPratica < 1 || $statoPratica > 15) {
            $param[1] = ">?";
            $statoPratica = 0;
        } else {
            $param[1] = "=? ";
        }

        if ($tipoPratica == null || $tipoPratica < 1 || $tipoPratica > 3) {
            $param[2] = ">?";
            $tipoPratica = 0;
        } else {
            $param[2] = "=? ";
        }
        
        if ($incaricato == null || $incaricato < 1 ) {
            $param[3] = ">?";
            $incaricato = 0;
        } else {
            $param[3] = "=? ";
        }
        
        if ($flagAllaFirma == null || $flagAllaFirma < 0 || $flagAllaFirma > 1) {
            $param[4] = ">?";
            $flagAllaFirma = -1;
        } else {
            $param[4] = "=? ";
        }
        if ($flagFirmata == null || $flagFirmata < 0 || $flagFirmata > 1) {
            $param[5] = ">?";
            $flagFirmata = -1;
        } else {
            $param[5] = "=? ";
        }
        if ($flagSoprintendenza == null || $flagSoprintendenza < 0 || $flagSoprintendenza > 1) {
            $param[6] = ">?";
            $flagSoprintendenza = -1;
        } else {
            $param[6] = "=? ";
        }
        if ($flagInAttesa == null || $flagInAttesa < 0 || $flagInAttesa > 1) {
            $param[7] = ">?";
            $flagInAttesa = -1;
        } else {
            $param[7] = "=? ";
        }
        
        


        $stmt = $mysqli->stmt_init();

        $query = "SELECT pratica.id, pratica.contatto, date_format(dataAvvioProcedimento,'%d/%m/%Y') dataAvvioProcedimento, 
            date_format(dataCaricamento,'%d/%m/%Y') dataCaricamento, date_format(dataConferenzaServizi,'%d/%m/%Y') 
            dataConferenzaServizi, date_format(dataInvioRicevuta,'%d/%m/%Y') dataInvioRicevuta,
            date_format(dataInvioVerifiche,'%d/%m/%Y') dataInvioVerifiche, date_format(dataProtocollo,'%d/%m/%Y') 
            dataProtocollo, date_format(dataProvvedimento,'%d/%m/%Y') dataProvvedimento, flagAllaFirma, flagFirmata, 
            flagInAttesa, flagSoprintendenza, importoDiritti, incaricato, motivoAttesa, numeroPratica, numeroProtocollo, 
            numeroProtocolloProvvedimento, oggetto, procuratore, richiedente, statoPratica, tipoPratica, ubicazione, 
            anagrafica.nome, anagrafica.cognome, anagrafica.contatto, an2.nome, an2.cognome, an2.contatto 
            FROM pratica JOIN anagrafica ON anagrafica.id=richiedente JOIN anagrafica an2 ON an2.id=procuratore 
            WHERE numeroPratica" . $param[0] . " AND statoPratica" . $param[1] . " AND tipoPratica" . $param[2]
                . " AND incaricato" . $param[3] . " AND flagAllaFirma" . $param[4] . " AND flagFirmata" . $param[5]
                . " AND flagSoprintendenza" . $param[6] . " AND flagInAttesa" . $param[7] . " ORDER BY numeroPratica DESC LIMIT ?,?";

        $stmt->prepare($query);
        $stmt->bind_param("iiiiiiiiii", $numeroPratica, $statoPratica, $tipoPratica, $incaricato, $flagAllaFirma, $flagFirmata, $flagSoprintendenza, $flagInAttesa, $offset, $numero);

        $result = $stmt->execute();
        $stmt->bind_result($id, $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione, $nomeRichiedente, $cognomeRichiedente, $contattoRichiedente, $nomeProcuratore, $cognomeProcuratore, $contattoProcuratore);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $mysqli->close();
            return $errore;
            //return null;
        } else {
            $pratiche = array();
            while ($stmt->fetch()) {
                $pratica = new Pratica();
                $pratica->setId($id);
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
                $pratiche[] = $pratica;
            }
            $mysqli->close();
            return $pratiche;
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
        $procuratoreId = $pratica->getProcuratoreId();
        $richiedenteId = $pratica->getRichiedenteId();
        $statoPratica = $pratica->getStatoPratica();
        $tipoPratica = $pratica->getTipoPratica();
        $ubicazione = $pratica->getUbicazione();

        $stmt = $mysqli->stmt_init();
        $query = "UPDATE pratica SET contatto=?, dataAvvioProcedimento=?, dataCaricamento=?, dataConferenzaServizi=?, "
                . "dataInvioRicevuta=?, dataInvioVerifiche=?, dataProtocollo=?, dataProvvedimento=?, flagAllaFirma=?, "
                . "flagFirmata=?, flagInAttesa=?, flagSoprintendenza=?, importoDiritti=?, incaricato=?, motivoAttesa=?, "
                . "numeroPratica=?, numeroProtocollo=?, numeroProtocolloProvvedimento=?, oggetto=?, procuratore=?, "
                . "richiedente=?, statoPratica=?, tipoPratica=?, ubicazione=? WHERE id=? ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiisi", $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $tipoPratica, $ubicazione, $id);

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

    public static function ricercaPerNumeroPratica($numeroP) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT id FROM pratica WHERE numeroPratica=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $numeroP);

        $result = $stmt->execute();
        $stmt->bind_result($id);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $stmt->close();
            $mysqli->close();
            return null;
        } else {
            $stmt->fetch();
            $stmt->close();
            $mysqli->close();
            return $id;
        }
    }
    
    public static function statoPratica($statoPratica) {
        switch ($statoPratica) {
            case 1:
                $statoPratica= "Caricata su Sardegna Suap";
                break;
            case 2:
                $statoPratica= "Protocollata";
                break;
            case 3:
                $statoPratica= "Assegnata a operatore";
                break;
            case 4:
                $statoPratica= "In attesa di Verifica formale";
                break;
            case 5:
                $statoPratica= "In attesa di Avvio procedimento";
                break;
            case 6:
                $statoPratica= "In attesa di Rilascio ricevuta";
                break;
            case 7:
                $statoPratica= "In attesa di Invio per verifiche ad enti terzi";
                break;
            case 8:
                $statoPratica= "In attesa di integrazioni rich. da enti terzi";
                break;
            case 9:
                $statoPratica= "Conferenza servizi -> Attesa pareri";
                break;
            case 10:
                $statoPratica= "Conferenza servizi -> Convocata";
                break;
            case 11:
                $statoPratica= "Conferenza servizi -> Aperta";
                break;
            case 12:
                $statoPratica= "Conferenza servizi -> Verbalizzata";
                break;
            case 13:
                $statoPratica= "Conferenza servizi -> Provvedimento unico";
                break;
            case 14:
                $statoPratica= "Chiusa -> Esito Positivo";
                break;
            case 15:
                $statoPratica= "Chiusa -> Archiviata";
                break;

            default:
                break;
        }
        return $statoPratica;
    }
    
    public static function tipoPratica($tipoPratica) {
        switch ($tipoPratica) {
            case 1:
                $tipoPratica= "Immediato avvio - 0 gg";
                break;
            case 2:
                $tipoPratica= "Immediato avvio - 20 gg";
                break;
            case 3:
                $tipoPratica= "Conferenza di Servizi";
                break;

            default:
                break;
        }
        return $tipoPratica;
    }
    

}

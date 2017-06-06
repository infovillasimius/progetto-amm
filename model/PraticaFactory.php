<?php

include_once './model/Pratica.php';

class PraticaFactory {

    /**
     * Salva pratica sul database
     * @param \Pratica $pratica
     * @return boolean|int
     */
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
        $suap=$pratica->getSuap();
        $tipoPratica = $pratica->getTipoPratica();
        $ubicazione = $pratica->getUbicazione();

        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO pratica (id, contatto, dataAvvioProcedimento, dataCaricamento, dataConferenzaServizi, "
                . "dataInvioRicevuta, dataInvioVerifiche, dataProtocollo, dataProvvedimento, flagAllaFirma, "
                . "flagFirmata, flagInAttesa, flagSoprintendenza, importoDiritti, incaricato, motivoAttesa, "
                . "numeroPratica, numeroProtocollo, numeroProtocolloProvvedimento, oggetto, procuratore, "
                . "richiedente, statoPratica, suap, tipoPratica, ubicazione) VALUES (default, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiiis", $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $suap, $tipoPratica, $ubicazione);

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

    /**
     * Restituisce una pratica in base all'id
     * @param int $idPratica
     * @return \Pratica
     */
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
                . "statoPratica, suap, tipoPratica, ubicazione, anagrafica.nome, anagrafica.cognome, "
                . "anagrafica.contatto, an2.nome, an2.cognome, an2.contatto "
                . "FROM pratica JOIN anagrafica ON richiedente=anagrafica.id JOIN anagrafica an2 ON procuratore=an2.id WHERE pratica.id=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $idPratica);

        $result = $stmt->execute();
        $stmt->bind_result($id, $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $suap, $tipoPratica, $ubicazione, $nomeRichiedente, $cognomeRichiedente, $contattoRichiedente, $nomeProcuratore, $cognomeProcuratore, $contattoProcuratore);

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
            $pratica->setProcuratore(AnagraficaFactory::getAnagrafica($procuratoreId)->getNominativo());
            $pratica->setProcuratoreId($procuratoreId);
            $pratica->setRichiedente(AnagraficaFactory::getAnagrafica($richiedenteId)->getNominativo());
            $pratica->setRichiedenteId($richiedenteId);
            $pratica->setStatoPratica($statoPratica);
            $pratica->setSuap($suap);
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

        if ($statoPratica == null || $statoPratica < -2 || $statoPratica > 15 || $statoPratica == 0) {
            $param[1] = ">?";
            $statoPratica = 0;
        } elseif ($statoPratica == -1) {
            $param[1] = "<?";
            $statoPratica = 14;
        } elseif ($statoPratica == -2) {
            $param[1] = ">?";
            $statoPratica = 13;
        } else {
            $param[1] = "=? ";
        }

        if ($tipoPratica == null || $tipoPratica < 1 || $tipoPratica > 3) {
            $param[2] = ">?";
            $tipoPratica = 0;
        } else {
            $param[2] = "=? ";
        }

        if ($incaricato == null || $incaricato < 1) {
            $param[3] = ">?";
            $incaricato = 0;
        } else {
            $param[3] = "=? ";
        }

        if ($flagAllaFirma == null || $flagAllaFirma < 0 || $flagAllaFirma > 1) {
            $param[4] = ">?";
            $flagAllaFirma = -1;
        } else {
            $param[4] = "=(?) ";
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
            numeroProtocolloProvvedimento, oggetto, procuratore, richiedente, statoPratica, suap, tipoPratica, ubicazione, 
            anagrafica.nome, anagrafica.cognome, anagrafica.contatto, an2.nome, an2.cognome, an2.contatto, dataCaricamento as dataC 
            FROM pratica JOIN anagrafica ON anagrafica.id=richiedente JOIN anagrafica an2 ON an2.id=procuratore 
            WHERE numeroPratica" . $param[0] . " AND statoPratica" . $param[1] . " AND tipoPratica" . $param[2]
                . " AND incaricato" . $param[3] . " AND flagAllaFirma" . $param[4] . " AND flagFirmata" . $param[5]
                . " AND flagSoprintendenza" . $param[6] . " AND flagInAttesa" . $param[7] . " ORDER BY dataC DESC, numeroPratica DESC LIMIT ?,?";

        $stmt->prepare($query);
        $stmt->bind_param("iiiiiiiiii", $numeroPratica, $statoPratica, $tipoPratica, $incaricato, $flagAllaFirma, $flagFirmata, $flagSoprintendenza, $flagInAttesa, $offset, $numero);

        $result = $stmt->execute();
        $stmt->bind_result($id, $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $suap, $tipoPratica, $ubicazione, $nomeRichiedente, $cognomeRichiedente, $contattoRichiedente, $nomeProcuratore, $cognomeProcuratore, $contattoProcuratore,$dataC);

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
                $pratica->setProcuratore(AnagraficaFactory::getAnagrafica($procuratoreId)->getNominativo());
                $pratica->setProcuratoreId($procuratoreId);
                $pratica->setRichiedente(AnagraficaFactory::getAnagrafica($richiedenteId)->getNominativo());
                $pratica->setRichiedenteId($richiedenteId);
                $pratica->setStatoPratica($statoPratica);
                $pratica->setSuap($suap);
                $pratica->setTipoPratica($tipoPratica);
                $pratica->setUbicazione($ubicazione);
                $pratiche[] = $pratica;
            }
            $mysqli->close();
            return $pratiche;
        }
    }

    /**
     * Aggiorna una pratica nel database
     * @param \Pratica $pratica
     * @return boolean|int
     */
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
        $suap=$pratica->getSuap();
        $tipoPratica = $pratica->getTipoPratica();
        $ubicazione = $pratica->getUbicazione();

        $stmt = $mysqli->stmt_init();
        $query = "UPDATE pratica SET contatto=?, dataAvvioProcedimento=?, dataCaricamento=?, dataConferenzaServizi=?, "
                . "dataInvioRicevuta=?, dataInvioVerifiche=?, dataProtocollo=?, dataProvvedimento=?, flagAllaFirma=?, "
                . "flagFirmata=?, flagInAttesa=?, flagSoprintendenza=?, importoDiritti=?, incaricato=?, motivoAttesa=?, "
                . "numeroPratica=?, numeroProtocollo=?, numeroProtocolloProvvedimento=?, oggetto=?, procuratore=?, "
                . "richiedente=?, statoPratica=?, suap=?, tipoPratica=?, ubicazione=? WHERE id=? ";

        $stmt->prepare($query);
        $stmt->bind_param("ssssssssiiiidisiiisiiiiisi", $contatto, $dataAvvioProcedimento, $dataCaricamento, $dataConferenzaServizi, $dataInvioRicevuta, $dataInvioVerifiche, $dataProtocollo, $dataProvvedimento, $flagAllaFirma, $flagFirmata, $flagInAttesa, $flagSoprintendenza, $importoDiritti, $incaricato, $motivoAttesa, $numeroPratica, $numeroProtocollo, $numeroProtocolloProvvedimento, $oggetto, $procuratoreId, $richiedenteId, $statoPratica, $suap, $tipoPratica, $ubicazione, $id);

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
    
    /**
     * Restituisce id pratica in base al numero (codice univoco) della stessa
     * @param int $numeroP
     * @return int
     */
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
    /**
     * Restituisce la stringa corrispondente al valore numero dello stato pratica
     * @param int $statoPratica
     * @return string
     */
    public static function statoPratica($statoPratica) {
        switch ($statoPratica) {
            case 1:
                $statoPratica = "Caricata su Sardegna Suap";
                break;
            case 2:
                $statoPratica = "Protocollata";
                break;
            case 3:
                $statoPratica = "Assegnata a operatore";
                break;
            case 4:
                $statoPratica = "In attesa: Verifica formale";
                break;
            case 5:
                $statoPratica = "In attesa: Avvio proc.";
                break;
            case 6:
                $statoPratica = "In attesa: Ricevuta";
                break;
            case 7:
                $statoPratica = "In attesa: invio verif. enti t.";
                break;
            case 8:
                $statoPratica = "In attesa: integr. rich. da enti t.";
                break;
            case 9:
                $statoPratica = "C.d.S. -> Attesa pareri";
                break;
            case 10:
                $statoPratica = "C.d.S. -> Convocata";
                break;
            case 11:
                $statoPratica = "C.d.S. -> Aperta";
                break;
            case 12:
                $statoPratica = "C.d.S. -> Verbalizzata";
                break;
            case 13:
                $statoPratica = "C.d.S. -> Provv. unico";
                break;
            case 14:
                $statoPratica = "Chiusa -> Esito Positivo";
                break;
            case 15:
                $statoPratica = "Chiusa -> Archiviata";
                break;

            default:
                break;
        }
        return $statoPratica;
    }

    /**
     * Restituisce il nome corrispondente al tipo pratica numerico
     * @param int $tipoPratica
     * @return string
     */
    public static function tipoPratica($tipoPratica) {
        switch ($tipoPratica) {
            case 1:
                $tipoPratica = "Imm. avvio - 0 gg";
                break;
            case 2:
                $tipoPratica = "Imm. avvio - 20 gg";
                break;
            case 3:
                $tipoPratica = "Conf. di Servizi";
                break;

            default:
                break;
        }
        return $tipoPratica;
    }

    /**
     * Restituisce il numero totale delle pratiche in archivio
     * @return int
     */
    public static function numeroTotalePratiche() {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM pratica";
        $stmt->prepare($query);

        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

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
            return $numeroPratiche;
        }
    }
    
    
    /**
     * Restituisce il numero totale delle pratiche in archivio
     * @return int
     */
    public static function totaleDiritti() {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT sum(`importoDiritti`) FROM `pratica` WHERE 1";
        $stmt->prepare($query);

        $result = $stmt->execute();
        $stmt->bind_result($totaleDiritti);

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
            return $totaleDiritti;
        }
    }
    
    /**
     * Restituisce il numero totale delle pratiche in archivio per il comune selezionato
     * @param int $numero
     * @return int
     */
    public static function numeroTotalePraticheComune($numero) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM pratica WHERE SUAP=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $numero);
        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

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
            return $numeroPratiche;
        }
    }
    
    /**
     * Restituisce il numero totale delle pratiche in archivio per il comune selezionato per l'anno selezionato
     * @param int $numero
     * @return int
     */
    public static function numeroTotalePraticheComunePerAnno($numero,$anno) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        
        $inizio=$anno.'-01-01';
        $fine=$anno.'-12-31';
        
        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM pratica WHERE SUAP=? and dataCaricamento<? and dataCaricamento>?";
        $stmt->prepare($query);
        $stmt->bind_param("iss", $numero,$fine,$inizio);
        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

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
            return $numeroPratiche;
        }
    }
    
    /**
     * Restituisce il numero delle pratiche in archivio per il comune selezionato e del tipo selezionato
     * @param int $numero,$tipo
     * @return int
     */
    public static function numeroPraticheComunePerTipo($numero,$tipo) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM pratica WHERE SUAP=? and tipoPratica=?";
        $stmt->prepare($query);
        $stmt->bind_param("ii", $numero,$tipo);
        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

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
            return $numeroPratiche;
        }
    }
    
     /**
     * Restituisce il numero delle pratiche in archivio per il comune selezionato,del tipo selezionato e per l'anno selezionato
     * @param int $numero,$tipo
     * @return int 
     */
    public static function numeroPraticheComunePerTipoPerAnno($numero,$tipo,$anno) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        $inizio=$anno.'-01-01';
        $fine=$anno.'-12-31';
        
        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM pratica WHERE SUAP=? and tipoPratica=? and dataCaricamento<? and dataCaricamento>?";
        $stmt->prepare($query);
        $stmt->bind_param("iiss", $numero,$tipo,$fine,$inizio);
        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

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
            return $numeroPratiche;
        }
    }
    
    /**
     * Esegue una ricerca nelle pratiche e restituisce il numero delle pratiche che 
     * soddisfano i criteri di ricerca
     * @param array associativo $ricerca
     * @param int $offset
     * @param int $numero
     * @param string $ordinamento
     * @return \Pratica
     */
    public static function elencoNumeroP($ricerca) {
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

        if ($statoPratica == null || $statoPratica < -2 || $statoPratica > 15 || $statoPratica == 0) {
            $param[1] = ">?";
            $statoPratica = 0;
        } elseif ($statoPratica == -1) {
            $param[1] = "<?";
            $statoPratica = 14;
        } elseif ($statoPratica == -2) {
            $param[1] = ">?";
            $statoPratica = 13;
        } else {
            $param[1] = "=? ";
        }

        if ($tipoPratica == null || $tipoPratica < 1 || $tipoPratica > 3) {
            $param[2] = ">?";
            $tipoPratica = 0;
        } else {
            $param[2] = "=? ";
        }

        if ($incaricato == null || $incaricato < 1) {
            $param[3] = ">?";
            $incaricato = 0;
        } else {
            $param[3] = "=? ";
        }

        if ($flagAllaFirma == null || $flagAllaFirma < 0 || $flagAllaFirma > 1) {
            $param[4] = ">?";
            $flagAllaFirma = -1;
        } else {
            $param[4] = "=(?) ";
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

        $query = "SELECT count(*) FROM pratica WHERE numeroPratica" 
                . $param[0] . " AND statoPratica" . $param[1] . " AND tipoPratica" . $param[2]
                . " AND incaricato" . $param[3] . " AND flagAllaFirma" . $param[4] . " AND flagFirmata" 
                . $param[5] . " AND flagSoprintendenza" . $param[6] . " AND flagInAttesa" 
                . $param[7];
        
        
        $stmt->prepare($query);
        $stmt->bind_param("iiiiiiii", $numeroPratica, $statoPratica, $tipoPratica, $incaricato, $flagAllaFirma, $flagFirmata, $flagSoprintendenza, $flagInAttesa);
        
        $result = $stmt->execute();
        $stmt->bind_result($numeroPratiche);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $mysqli->close();
            return $errore;
            //return null;
        } else {           
            $stmt->fetch();
            $stmt->close();
            $mysqli->close();
            return $numeroPratiche;
        }
    }
   
}

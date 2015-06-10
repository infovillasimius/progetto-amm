<?php

/**
 * Class Pratica
 * Memorizza tutti gli attributi necessari alla gestione di una pratica SUAP
 * @author Antonello Meloni
 */
class Pratica {

    private $id;
    private $contatto;
    private $dataAvvioProcedimento;
    private $dataCaricamento;
    private $dataConferenzaServizi;
    private $dataInvioRicevuta;
    private $dataInvioVerifiche;
    private $dataProtocollo;
    private $dataProvvedimento;
    private $flagAllaFirma;
    private $flagFirmata;
    private $flagInAttesa;
    private $flagSoprintendenza;
    private $importoDiritti;
    private $incaricato;
    private $motivoAttesa;
    private $numeroPratica;
    private $numeroProtocollo;
    private $numeroProtocolloProvvedimento;
    private $oggetto;
    private $procuratore;
    private $procuratoreId;
    private $richiedente;
    private $richiedenteId;
    private $statoPratica;
    private $tipoPratica;
    private $ubicazione;

    /**
     * Imposta id della pratica
     * @param int $id
     * @return boolean true se impostato correttamente
     */
    public function setId($id) {
        $this->id = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->id != null;
    }

    /**
     * Restituisce id pratica
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Imposta numeroPratica
     * @param int $numero
     * @return boolean true se impostato correttamente
     */
    public function setNumeroPratica($numero) {
        $this->numeroPratica = filter_var($numero, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->numeroPratica != null;
    }

    /**
     * Restituisce il numero della pratica
     * @return int
     */
    public function getNumeroPratica() {
        return $this->numeroPratica;
    }

    /**
     * Imposta numeroProtocollo
     * @param int $numero
     * @return boolean true se impostato correttamente
     */
    public function setNumeroProtocollo($numero) {
        $this->numeroProtocollo = filter_var($numero, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->numeroProtocollo != null;
    }

    /**
     * Restituisce numero protocollo
     * @return int
     */
    public function getNumeroProtocollo() {
        return $this->numeroProtocollo;
    }

    /**
     * Sette il flag "alla Firma del Responsabile"
     * @param boolean $flag
     * @return boolean true se impostato correttamente
     */
    public function setFlagAllaFirma($flag) {
        $this->flagAllaFirma = filter_var($flag, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return $this->flagAllaFirma != null;
    }

    /**
     * Restituisce flag "alla firma del Responsabile"
     * @return boolean
     */
    public function getFlagAllaFirma() {
        return $this->flagAllaFirma;
    }

    /**
     * Sette il flag " Firmata dal Responsabile"
     * @param boolean $flag
     * @return boolean true se impostato correttamente
     */
    public function setFlagFirmata($flag) {
        $this->flagFirmata = filter_var($flag, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return $this->flagFirmata != null;
    }

    /**
     * Restituisce flag "firmata dal Responsabile"
     * @return boolean
     */
    public function getFlagFirmata() {
        return $this->flagFirmata;
    }

    /**
     * Setta la flag "Pratica in attesa"
     * @param boolean $flag
     * @return boolean true se impostato correttamente
     */
    public function setFlagInAttesa($flag) {
        $this->flagInAttesa = filter_var($flag, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return ($this->flagInAttesa != null);
    }

    /**
     * Restituisce flag "Pratica in attesa"
     * @return boolean
     */
    public function getFlagInAttesa() {
        return $this->flagInAttesa;
    }

    /**
     * Imposta il richiedente
     * @param int $id
     * @return boolean true se impostato correttamente
     */
    public function setRichiedenteId($id) {
        $this->richiedenteId = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->richiedenteId != null;
    }

    /**
     * Restituisce il richiedente
     * @return int
     */
    public function getRichiedenteId() {
        return $this->richiedenteId;
    }

    /**
     * Imposta oggetto pratica
     * @param String $oggetto
     * @return boolean true se impostato correttamente
     */
    public function setOggetto($oggetto) {
        $this->oggetto = $oggetto;
        return $this->oggetto != null;
    }

    /**
     * Restituisce oggetto pratica
     * @return string
     */
    public function getOggetto() {
        return $this->oggetto;
    }

    /**
     * Imposta id impiegato incaricato
     * @param int $incaricato
     * @return boolean true se impostato correttamente
     */
    public function setIncaricato($incaricato) {
        $this->incaricato = filter_var($incaricato, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->incaricato != null;
    }

    /**
     * Restituisce id impiegato incaricato
     * @return int
     */
    public function getIncaricato() {
        return $this->incaricato;
    }

    /**
     * Imposta il tipo della pratica
     * @param int $tipoPratica
     * @return boolean true se impostato correttamente
     */
    public function setTipoPratica($tipoPratica) {
        $this->tipoPratica = filter_var($tipoPratica, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->tipoPratica != null;
    }

    /**
     * Restituisce id tipo pratica
     * @return int
     */
    public function getTipoPratica() {
        return $this->tipoPratica;
    }

    /**
     * Imposta motivo dello stato di attesa della pratica
     * @param String $motivoAttesa
     * @return boolean true se impostato correttamente
     */
    public function setMotivoAttesa($motivoAttesa) {
        $this->motivoAttesa = $motivoAttesa;
        return $this->motivoAttesa != null;
    }

    /**
     * Restituisce il motivo dello stato di attesa della pratica
     * @return string
     */
    public function getMotivoAttesa() {
        return $this->motivoAttesa;
    }

    /**
     * Setta il flag che indica se è coinvolta la Soprintendenza
     * @param boolean $flag
     * @return boolean
     */
    public function setFlagSoprintendenza($flag) {
        $this->flagSoprintendenza = filter_var($flag, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return $this->flagSoprintendenza != null;
    }

    /**
     * Restituisce flag "Soprintendenza"
     * @return boolean
     */
    public function getFlagSoprintendenza() {
        return $this->flagSoprintendenza;
    }

    /**
     * Verifica se un input è una data valida e restituisce un valure unix timestamp
     * @param String $input 
     * @return int (unix timestamp)
     */
    private function dataControl($input) {
        $input = trim($input);
        $date_format = 'd.m.Y';
        $input = filter_var($input, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{2}[\-\/.]{1}[0-9]{2}[\-\/.]{1}[0-9]{4}/')));
        $input = str_replace('/', '.', $input);
        $input = str_replace('-', '.', $input);
        $time = strtotime($input);
        if (date($date_format, $time) == $input) {
            return $time;
        }
        return null;
    }

    /**
     * Restituisce stringa data in formato gg.mm.aaaa
     * @param int $time unix timestamp  
     * @return string
     */
    private function dataToString($time) {
        $date_format = 'd.m.Y';
        return date($date_format, $time);
    }

    /**
     * Imposta data di avvio del procedimento
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataAvvioProcedimento($data) {
        $this->dataAvvioProcedimento = self::dataControl($data);
        return $this->dataAvvioProcedimento != null;
    }

    /**
     * Restituisce data di avvio procedimento in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataAvvioProcedimento() {
        if (isset($this->dataAvvioProcedimento)) {
            return self::dataToString($this->dataAvvioProcedimento);
        }
        return "";
    }

    /**
     * Imposta data di caricamento del procedimento
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataCaricamento($data) {
        $this->dataCaricamento = self::dataControl($data);
        return $this->dataCaricamento != null;
    }

    /**
     * Restituisce data di caricamento del procedimento in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataCaricamento() {
        if (isset($this->dataCaricamento)) {
            return self::dataToString($this->dataCaricamento);
        }
        return "";
    }

    /**
     * Imposta data della Conferenza Servizi 
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataConferenzaServizi($data) {
        $this->dataConferenzaServizi = self::dataControl($data);
        return $this->dataConferenzaServizi != null;
    }

    /**
     * Restituisce data Conferenza Servizi in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataConferenzaServizi() {
        if (isset($this->dataConferenzaServizi)) {
            return self::dataToString($this->dataConferenzaServizi);
        }
        return "";
    }

    /**
     * Imposta data Invio Ricevuta  
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataInvioRicevuta($data) {
        $this->dataInvioRicevuta = self::dataControl($data);
        return $this->dataInvioRicevuta != null;
    }

    /**
     * Restituisce data Invio Ricevuta in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataInvioRicevuta() {
        if (isset($this->dataInvioRicevuta)) {
            return self::dataToString($this->dataInvioRicevuta);
        }
        return "";
    }

    /**
     * Imposta data Invio Verifiche  
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataInvioVerifiche($data) {
        $this->dataInvioVerifiche = self::dataControl($data);
        return $this->dataInvioVerifiche != null;
    }

    /**
     * Restituisce data Invio Verifiche in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataInvioVerifiche() {
        if (isset($this->dataInvioVerifiche)) {
            return self::dataToString($this->dataInvioVerifiche);
        }
        return "";
    }

    /**
     * Imposta data Protocollo  
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataProtocollo($data) {
        $this->dataProtocollo = self::dataControl($data);
        return $this->dataProtocollo != null;
    }

    /**
     * Restituisce data Protocollo in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataProtocollo() {
        if (isset($this->dataProtocollo)) {
            return self::dataToString($this->dataProtocollo);
        }
        return "";
    }

    /**
     * Imposta data Provvedimento  
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataProvvedimento($data) {
        $this->dataProvvedimento = self::dataControl($data);
        return $this->dataProvvedimento != null;
    }

    /**
     * Restituisce data Provvedimento in formato gg.mm.aaaa
     * @return string 
     */
    public function getDataProvvedimento() {
        if (isset($this->dataProvvedimento)) {
            return self::dataToString($this->dataProvvedimento);
        }
        return "";
    }

    /**
     * Imposta lo stato della pratica
     * @param int $statoPratica
     * @return boolean true se impostato correttamente
     */
    public function setStatoPratica($statoPratica) {
        $this->statoPratica = filter_var($statoPratica, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->statoPratica != null;
    }

    /**
     * Restituisce id stato pratica
     * @return int
     */
    public function getStatoPratica() {
        return $this->statoPratica;
    }

    /**
     * Imposta il procuratore
     * @param int $id
     * @return boolean true se impostato correttamente
     */
    public function setProcuratoreId($id) {
        $this->procuratoreId = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->procuratoreId != null;
    }

    /**
     * Restituisce id procuratore
     * @return int
     */
    public function getProcuratoreId() {
        return $this->procuratoreId;
    }

    /**
     * Imposta numeroProtocolloProvvedimento
     * @param int $numero
     * @return boolean true se impostato correttamente
     */
    public function setNumeroProtocolloProvvedimento($numero) {
        $this->numeroProtocolloProvvedimento = filter_var($numero, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->numeroProtocolloProvvedimento != null;
    }

    /**
     * Restituisce numero protocollo provvedimento
     * @return int
     */
    public function getNumeroProtocolloProvvedimento() {
        return $this->numeroProtocolloProvvedimento;
    }

    /**
     * Imposta ubicazione attività
     * @param String $ubicazione
     * @return boolean true se impostato correttamente
     */
    public function setUbicazione($ubicazione) {
        $this->ubicazione = $ubicazione;
        return $this->ubicazione != null;
    }

    /**
     * Restituisce ubicazione attività
     * @return string
     */
    public function getUbicazione() {
        return $this->ubicazione;
    }

    /**
     * Imposta contatto pratica
     * @param String $contatto
     * @return boolean true se impostato correttamente
     */
    public function setContatto($contatto) {
        $this->contatto = $contatto;
        return $this->contatto != null;
    }

    /**
     * Restituisce ubicazione attività
     * @return string
     */
    public function getContatto() {
        return $this->contatto;
    }

    /**
     * Imposta importo diritti SUAP
     * @param int $importo
     * @return boolean true se impostato correttamente
     */
    public function setImportoDiritti($importo) {
        $this->importoDiritti = filter_var($importo, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
        return $this->importoDiritti != null;
    }

    /**
     * Restituisce importo diritti SUAP
     * @return float
     */
    public function getImportoDiritti() {
        return $this->importoDiritti;
    }
    
    /**
     * Restituisce nominativo richiedente
     * @return string
     */
    public function getRichiedente() {
        return $this->richiedente;
    }
    
    /**
     * Imposta nominativo richiedente
     * @param string $nominativo
     * @return boolean
     */
    public function setRichiedente($nominativo) {
        $this->richiedente=$nominativo;
        return $this->richiedente!=null;
    }
    
    /**
     * Restituisce nominativo procuratore
     * @return string
     */
    public function getProcuratore() {
        return $this->procuratore;
    }
    
    /**
     * Imposta nominativo Procuratore
     * @param string $nominativo
     * @return boolean
     */
    public function setProcuratore($nominativo) {
        $this->procuratore=$nominativo;
        return $this->richiedente!=null;
    }
    
    

}

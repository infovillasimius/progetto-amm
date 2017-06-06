<?php

/**
 * Class Provvedimento
 * Memorizza tutti gli attributi necessari alla gestione dei provvedimenti unici
 * @author Antonello Meloni
 */
class Provvedimento{
    private $id;
    private $numeroProvvedimento;
    private $dataProvvedimento;
    private $numeroProtocollo;
    private $dataProtocollo;
    private $praticaCollegata;

    /**
     * Imposta id provvedimento
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
     * Imposta pratica collegata
     * @param int $numero
     * @return boolean true se impostato correttamente
     */
    public function setPraticaCollegata($numero) {
        $this->praticaCollegata = filter_var($numero, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->praticaCollegata != null;
    }

    /**
     * Restituisce pratica collegata
     * @return int
     */
    public function getPraticaCollegata() {
        return $this->praticaCollegata;
    }
    
    /**
     * Imposta numeroProvvedimento
     * @param int $numero
     * @return boolean true se impostato correttamente
     */
    public function setNumeroProvvedimento($numero) {
        $this->numeroProvvedimento = filter_var($numero, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->numeroProvvedimento != null;
    }

    /**
     * Restituisce il numero della pratica
     * @return int
     */
    public function getNumeroProvvedimento() {
        return $this->numeroProvvedimento;
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
    private function dataToString($time, $r) {
        if ($r) {
            $date_format = 'd.m.Y';
        } else {
            $date_format = 'Y.m.d';
        }
        return date($date_format, $time);
    }
    
    /**
     * Imposta data del provvedimento
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataProvvedimento($data) {
        $this->dataProvvedimento = self::dataControl($data);
        return $this->dataProvvedimento != null;
    }

    /**
     * Restituisce data del provvedimento 
     * @param boolean $r se true in formato gg.mm.aaaa altrimenti aaaa.mm.gg
     * @return string 
     */
    public function getDataProvvedimento($r) {
        if (isset($this->dataProvvedimento)) {
            return self::dataToString($this->dataProvvedimento, $r);
        }
        return "";
    }
    
     /**
     * Imposta data del Protocollo
     * @param String $data
     * @return boolean true se impostato correttamente
     */
    public function setDataProtocollo($data) {
        $this->dataProtocollo = self::dataControl($data);
        return $this->dataProtocollo != null;
    }

    /**
     * Restituisce data del Protocollo 
     * @param boolean $r se true in formato gg.mm.aaaa altrimenti aaaa.mm.gg
     * @return string 
     */
    public function getDataProtocollo($r) {
        if (isset($this->dataProtocollo)) {
            return self::dataToString($this->dataProtocollo, $r);
        }
        return "";
    }
    
    
}
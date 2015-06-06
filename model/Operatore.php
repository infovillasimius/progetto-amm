<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Operatore extends Anagrafica {

    private $id;
    private $idAn;
    private $funzione;
    private $username;
    private $password;

    /**
     * Imposta id operatore
     * @param int $id
     * @return boolean
     */
    public function setId($id) {
        $this->id = $id;
        return $this->id != null;
    }
    
    /**
     * Restituisce id operatore
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
        /**
     * Imposta id anagrafica
     * @param int $id
     * @return boolean
     */
    public function setIdAn($id) {
        $this->idAn = $id;
        return $this->idAn != null;
    }
    
    /**
     * Restituisce id anagrafica
     * @return int
     */
    public function getIdAn() {
        return $this->idAn;
    }

    /**
     * Imposta il parametro che individua la funzione dell'operatore
     * @param int $funzione (1 = operatore - 2 = protocollo - 3 = responsabile - 4 = amministratore)
     * @return boolean
     */
    public function setFunzione($funzione) {
        $this->funzione = filter_var($funzione, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        return $this->funzione != null;
    }

    /**
     * Restituisce il valore che individua la funzione dell'operatore
     * @return int $funzione (1 = operatore - 2 = protocollo - 3 = responsabile - 4 = amministratore)
     */
    public function getFunzione() {
        return $this->funzione;
    }

    /**
     * Restituisce la username dell'operatore
     * @return string Username operatore
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Imposta la username dell'operatore
     * @param string $username
     * @return boolean true se impostata correttamente
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this->username != null;
    }

    /**
     * Imposta la password dell'operatore
     * @param string $password
     * @return boolean true se impostata correttamente
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this->password != null;
    }

    public function getPassword() {
        return $this->password;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Anagrafica {

    private $nome;
    private $cognome;
    private $contatto;
    private $tipo;
    private $id;

    /**
     * Restituisce Il nome e il cognome 
     * @return string Nome + Cognome 
     */
    public function getNominativo() {
        if ($this->tipo == 1) {
            return $this->cognome;
        }
        return $this->cognome . " " . $this->nome;
    }

    /**
     * Imposta nome e cognome 
     * @param String $nome
     * @param String $cognome
     * @return boolean true se nome e cognome sono impostati correttamente
     */
    public function setNominativo($nome, $cognome) {
        if ($this->tipo) {
            $this->cognome = $cognome;
            return $this->cognome != null;
        }

        $this->nome = $nome;
        $this->cognome = $cognome;
        return $this->nome != null && $this->cognome != null;
    }

    /**
     * Imposta il nome
     * @param string $nome
     * @return boolean true se nome è impostato correttamente
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this->nome != null;
    }

    /**
     * Restituisce il nome
     * @return string nome 
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il cognome
     * @param type $cognome
     * @return boolean true se cognome è impostato correttamente
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return $this->cognome != null;
    }

    /**
     * Restituisce il cognome
     * @return string cognome
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * Restituisce il contatto (tel - mail) 
     * @return string Contatto anagrafica
     */
    public function getContatto() {
        return $this->contatto;
    }

    /**
     * Imposta nome e cognome 
     * @param String $nome
     * @param String $cognome
     * @return boolean true se nome e cognome sono impostati correttamente
     */
    public function setContatto($contatto) {
        $this->contatto = $contatto;
        return $this->contatto != null;
    }

    /**
     * Imposta il tipo anagrafica: Falso=persona fisica - vero= persona giuridica
     * @param boolean $tipo
     * @return boolean
     */
    public function setTipol($tipo) {
        $this->tipo = filter_var($tipo, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return ($this->tipo != null);
    }

    /**
     * Restituisce tipo anagrafica
     * @return boolean Falso=persona fisica - Vero= persona giuridica
     */
    public function getTipol() {
        return $this->tipo;
    }

    public function setId($id) {
        $this->id = $id;
        return $this->id != null;
    }

    public function getId() {
        return $this->id;
    }

}

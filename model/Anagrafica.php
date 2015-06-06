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
    
    /**
     * Restituisce Il nome e il cognome 
     * @return string Nome + Cognome 
     */
    public function getNominativo() {
        return $this->nome . " " . $this->cognome;
    }

    /**
     * Imposta nome e cognome 
     * @param String $nome
     * @param String $cognome
     * @return boolean true se nome e cognome sono impostati correttamente
     */
    public function setNominativo($nome, $cognome) {
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
        $this->nome=$nome;
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
        $this->cognome=$cognome;
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
    public function getContatto(){
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
}
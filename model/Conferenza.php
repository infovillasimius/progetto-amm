<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Conferenza {

    private $id;
    private $data;
    private $comune;
    private $ora;
    private $numeroPratica;

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getComune() {
        return $this->comune;
    }

    function getOra() {
        return $this->ora;
    }

    function getNumeroPratica() {
        return $this->numeroPratica;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setComune($comune) {
        $this->comune = $comune;
    }

    function setOra($ora) {
        $this->ora = $ora;
    }

    function setNumeroPratica($numeroPratica) {
        $this->numeroPratica = $numeroPratica;
    }

    public function giorno() {
        if($this->data != NULL){
            $d= $this->data;
        } else {
            $d="2017-01-01";
        }
        //attento la data deve essere nel formato yyyy-mm-gg
        //anche come separatori (se altri separatori devi modificare)
        $d_ex = explode("-", $d); //attento al separatore
        $d_ts = mktime(0, 0, 0, $d_ex[1], $d_ex[2], $d_ex[0]);
        $num_gg = (int) date("N", $d_ts); //1 (for Monday) through 7 (for Sunday)
        //per nomi in italiano
        $giorno = array('', 'lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'); //0 vuoto
        return $giorno[$num_gg];
    }

}

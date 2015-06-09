<?php


class PraticaFactory {

    public static function salvaP($pratica) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
            
            
            
        }
    }
    
    public static function getPraticaById($id) {
        
    }
    
    public static function elencoP($ricerca,$offset,$numero,$ordinamento) {
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

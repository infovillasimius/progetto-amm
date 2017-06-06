<?php

include_once './model/Provvedimento.php';

class ProvvedimentoFactory {

    /**
     * Salva provvedimento sul database
     * @param \Provvedimento $nuovoProvvedimento
     * @return boolean|int
     */
    public static function salvaProvvedimento($nuovoProvvedimento) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
        }

        $numeroProvvedimento = $nuovoProvvedimento->getNumeroProvvedimento();
        $dataProvvedimento = $nuovoProvvedimento->getDataProvvedimento(false);
        $numeroProtocollo = $nuovoProvvedimento->getNumeroProtocollo();
        $dataProtocollo = $nuovoProvvedimento->getDataProtocollo(false);
        $praticaCollegata = $nuovoProvvedimento->getPraticaCollegata();
        

        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO provvedimenti (id, numeroProvvedimento, dataProvvedimento, numeroProtocollo, dataProtocollo, "
                . "praticaCollegata) VALUES (default, ?,?,?,?,?) ";

        $stmt->prepare($query);
        $stmt->bind_param("isisi", $numeroProvvedimento, $dataProvvedimento, $numeroProtocollo, $dataProtocollo, $praticaCollegata);

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
     * Restituisce un oggetto Provvedimento a partire dall'id
     * @param type $id
     * @return \Provvedimento
     */
    public static function getProvvedimento($id) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return new Provvedimento();
        }
        $provvedimento = new Provvedimento();
        $stmt = $mysqli->stmt_init();
        $query = "SELECT id, numeroProvvedimento,date_format(dataProvvedimento,'%d/%m/%Y') dataProvvedimento,"
                . " numeroProtocollo, date_format(dataProtocollo,'%d/%m/%Y') dataProtocollo, praticaCollegata FROM provvedimenti where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($id, $numeroProvvedimento, $dataProvvedimento, $numeroProtocollo, $dataProtocollo,$praticaCollegata);
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query $mysqli->errno : $mysqli->error", 0);
            $stmt->close();
            $mysqli->close();
        } else {
            $stmt->fetch();
            $provvedimento->setNumeroProvvedimento($numeroProvvedimento);
            $provvedimento->setDataProvvedimento($dataProvvedimento);            
            $provvedimento->setNumeroProtocollo($numeroProtocollo);
            $provvedimento->setDataProtocollo($dataProtocollo);
            $provvedimento->setPraticaCollegata($praticaCollegata);
            $provvedimento->setId($id);
            $stmt->close();
            $mysqli->close();
            return $provvedimento;
        }
    }
    
      
    /**
     * Update provvedimento
     * @param \Provvedimento $provvedimento
     * @return int
     */
    public static function updateProvvedimento($provvedimento) {
        
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        
        $id=$provvedimento->getId();
        $numeroProvvedimento=$provvedimento->getNumeroProvvedimento();
        $dataProvvedimento=$provvedimento->getDataProvvedimento(false);            
        $numeroProtocollo=$provvedimento->getNumeroProtocollo();
        $dataProtocollo=$provvedimento->getDataProtocollo(false);
        $praticaCollegata=$provvedimento->getPraticaCollegata();
        
        $stmt = $mysqli->stmt_init();
        $query = "UPDATE provvedimenti SET numeroProvvedimento=?, dataProvvedimento=?, numeroProtocollo=?, dataProtocollo=?, praticaCollegata=? where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("isisii", $numeroProvvedimento, $dataProvvedimento, $numeroProtocollo, $dataProtocollo, $praticaCollegata, $id);
        $result=$stmt->execute();
        
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
     * Elenco provvedimenti
     * @param array associativo $ricerca
     * @param int $offset
     * @param int $numero
     * @param string $ordinamento
     * @return \Pratica
     */
    public static function elencoP($offset, $numero) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();

        $query = "SELECT id, numeroProvvedimento, date_format(dataProvvedimento,'%d/%m/%Y') dataProvvedimento, numeroProtocollo, date_format(dataProtocollo,'%d/%m/%Y') dataProtocollo, praticaCollegata FROM provvedimenti ORDER BY numeroProvvedimento DESC LIMIT ?,?";

        $stmt->prepare($query);
        $stmt->bind_param("ii", $offset, $numero);

        $result = $stmt->execute();
        $stmt->bind_result($id, $numeroProvvedimento, $dataProvvedimento, $numeroProtocollo, $dataProtocollo,$praticaCollegata);
        
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $mysqli->close();
            return $errore;
            //return null;
        } else {
            $provvedimenti = array();
            while ($stmt->fetch()) {
                $provvedimento = new Provvedimento();
                $provvedimento->setId($id);
                $provvedimento->setNumeroProvvedimento($numeroProvvedimento);
                $provvedimento->setDataProvvedimento($dataProvvedimento);            
                $provvedimento->setNumeroProtocollo($numeroProtocollo);
                $provvedimento->setDataProtocollo($dataProtocollo);
                $provvedimento->setPraticaCollegata($praticaCollegata);
                $provvedimenti[] = $provvedimento;
            }
            $mysqli->close();
            return $provvedimenti;
        }
    }
    
    /**
     * Restituisce il numero totale dei provvedimenti in archivio
     * @return int
     */
    public static function numeroTotaleProvvedimenti() {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $stmt = $mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM provvedimenti";
        $stmt->prepare($query);

        $result = $stmt->execute();
        $stmt->bind_result($numeroProvvedimenti);

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
            return $numeroProvvedimenti;
        }
    }

   

}

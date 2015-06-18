<?php

include_once 'model/ConnectionFactory.php';
include_once 'model/Anagrafica.php';

class AnagraficaFactory {

    /**
     * Restituisce un oggetto Anagrafica a partire dall'id
     * @param type $id
     * @return \Anagrafica
     */
    public static function getAnagrafica($id) {
        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return new Anagrafica();
        }
        $anagrafica = new Anagrafica();
        $stmt = $mysqli->stmt_init();
        $query = "SELECT * FROM anagrafica where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($id, $tipo, $nome, $cognome, $contatto);
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $stmt->close();
            $mysqli->close();
        } else {
            $row = $stmt->fetch();
            $anagrafica->setNome($nome);
            $anagrafica->setCognome($cognome);
            $anagrafica->setContatto($contatto);
            $anagrafica->setTipol($tipo);
            $stmt->close();
            $mysqli->close();
            return $anagrafica;
        }
    }

    public static function getAnagraficaByName($nomeOp, $cognomeOp, $mysqli) {
        if (!isset($mysqli)) {
            $mysqli = ConnectionFactory::connetti();
            $flag = 1;
            if (!isset($mysqli)) {
                return null;  
            }
        } else {
            $flag = 0;
        }
        $id = "";
        $stmt = $mysqli->stmt_init();
        $query = "SELECT id FROM anagrafica where LOWER(nome)=LOWER(?) and LOWER(cognome)=LOWER(?)";
        $stmt->prepare($query);
        $stmt->bind_param("ss", $nomeOp, $cognomeOp);
        $stmt->execute();
        $stmt->bind_result($id);

        $stmt->fetch();
        if (!isset($id)) {
            $stmt->close();
            $mysqli->close();
            return -1;
        } else {
            $stmt->close();
            if ($flag == 1) {
                $mysqli->close();
            }
            return $id;
        }
    }

    public static function setAnagrafica($tipo, $nome, $cognome, $contatto, $mysqli) {
        if (!isset($mysqli)) {
            $mysqli = ConnectionFactory::connetti();
            $flag = 1;
            if (!isset($mysqli)) {
                return null;
            }
        } else {
            $flag = 0;
        }
        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO anagrafica VALUES (default,?,?,?,?)";
        $stmt->prepare($query);
        $stmt->bind_param("isss", $tipo, $nome, $cognome, $contatto);
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);

            die("Errore nella query $query: " . mysql_error());
            return -1;
        } else {
            $id = mysqli_insert_id($mysqli);
            $stmt->close();
            if ($flag == 1) {
                $mysqli->close();
            }
            return $id;
        }
    }

    public static function updateAnagrafica($id, $tipo, $nome, $cognome, $contatto, $mysqli) {
        if (!isset($mysqli)) {
            $mysqli = ConnectionFactory::connetti();
            $flag = 1;
            if (!isset($mysqli)) {
                return null;
            }
        } else {
            $flag = 0;
        }
        $stmt = $mysqli->stmt_init();
        $query = "UPDATE anagrafica SET tipo=?, nome=?, cognome=?, contatto=? where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("isssi", $tipo, $nome, $cognome, $contatto, $id);
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);

            die("Errore nella query $query: " . mysql_error());
            return -1;
        } else {
            $stmt->close();
            if ($flag === 1) {
                $mysqli->close();
            }
            return 1;
        }
    }

    public static function getListaAnagraficaByName($nomeAn, $cognomeAn) {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        $cognomeAn='%'.$cognomeAn.'%';
        $nomeAn='%'.$nomeAn.'%';
        $stmt = $mysqli->stmt_init();
        $query = "SELECT id, tipo, nome, cognome, contatto FROM anagrafica where LOWER(nome) LIKE LOWER(?) and LOWER(cognome) LIKE LOWER(?) ORDER BY cognome LIMIT 20";
        $query2 = "SELECT COUNT(*) FROM anagrafica where LOWER(nome) LIKE LOWER(?) and LOWER(cognome) LIKE LOWER(?)";
        $stmt->prepare($query2);
        $stmt->bind_param("ss", $nomeAn, $cognomeAn);
        $stmt->execute();
        $stmt->bind_result($anagTrovate);
        $stmt->fetch();     
        $stmt->prepare($query);       
        $stmt->bind_param("ss", $nomeAn, $cognomeAn);
        $stmt->execute();
        $stmt->bind_result($id, $tipo, $nome, $cognome, $contatto);
               
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $mysqli->close();
            return null;
        } else {
            $anagrafiche = array();
            $anagrafiche[] = $anagTrovate;
            while ($stmt->fetch()) {
                $anagrafica = new Anagrafica();
                $anagrafica->setId($id);
                $anagrafica->setTipol($tipo);
                $anagrafica->setNominativo($nome, $cognome);
                $anagrafica->setContatto($contatto);
                $anagrafiche[] = $anagrafica;
            }
            $stmt->close();
            $mysqli->close();
//            var_dump($anagrafiche);
            return $anagrafiche;
        }
    }

}

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
        $query = "SELECT id, nome, cognome, contatto FROM anagrafica where id=$id";
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $anagrafica->setNominativo($row->nome, $row->cognome);
            $anagrafica->setContatto($row->contatto);
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
        $query = "SELECT id FROM anagrafica where nome=? and cognome=?";
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

    public static function setAnagrafica($nome, $cognome, $contatto, $mysqli) {
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
        $query = "INSERT INTO anagrafica VALUES (default,?,?,?)";
        $stmt->prepare($query);
        $stmt->bind_param("sss", $nome, $cognome, $contatto);
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

    public static function updateAnagrafica($id, $nome, $cognome, $contatto, $mysqli) {
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
        $query = "UPDATE anagrafica SET nome=?, cognome=?, contatto=? where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("sssi", $nome, $cognome, $contatto, $id);
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

    public static function updateAnagrafica2($id, $nome, $cognome, $contatto) {
        $mysqli = ConnectionFactory::connetti();

        if (!isset($mysqli)) {
            return null;
        }
        $query = "UPDATE anagrafica SET nome=?, cognome=?, contatto=? where id=?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        $stmt->bind_param("sssi", $nome, $cognome, $contatto, $id);
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            return -1;
        } else {
            $stmt->close();
            $mysqli->close();
            return 1;
        }
    }

}

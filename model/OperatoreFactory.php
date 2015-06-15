<?php

include_once 'model/ConnectionFactory.php';
include_once 'model/Anagrafica.php';
include_once 'model/Operatore.php';

class OperatoreFactory {

    /**
     * Restituisce un oggetto della classe operatore con i dati recuperati per id
     * @param int $id
     * @return \Operatore
     */
    public static function getOperatore($id) {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }
        $operatore = new Operatore();
        $query = "SELECT operatore.id, anagrafica.nome, anagrafica.cognome, anagrafica.contatto, operatore.funzione, operatore.username, operatore.password, operatore.id_anagrafica FROM anagrafica join operatore on anagrafica.id=operatore.id_anagrafica where operatore.id=$id";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $operatore->setNominativo($row->nome, $row->cognome);
            $operatore->setContatto($row->contatto);
            $operatore->setFunzione($row->funzione);
            $operatore->setUsername($row->username);
            $operatore->setPassword($row->password);
            $operatore->setId($row->id);
            $operatore->setIdAn($row->id_anagrafica);

            $mysqli->close();

            return $operatore;
        }
    }

    public static function getLoggedOP($username, $password) {

        $mysqli = ConnectionFactory::connetti();

        if (!isset($mysqli)) {
            return null;
        }
        $id = "";
        $stmt = $mysqli->stmt_init();
        $query = "SELECT id FROM operatore where username=? and password=?";
        $stmt->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($id);

        $stmt->fetch();
        if (!isset($id)) {
            $mysqli->close();
            $stmt->close();
            return null;
        } else {
            $mysqli->close();
            $stmt->close();
            return OperatoreFactory::getOperatore($id);
        }
    }

    public static function admin() {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $query = "SELECT id,nomeFunzione FROM funzione where nomeFunzione='Amministratore'";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $mysqli->close();
            return $row->id;
        }
    }

    public static function operatore() {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $query = "SELECT id,nomeFunzione FROM funzione where nomeFunzione='Operatore'";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $mysqli->close();
            return $row->id;
        }
    }

    public static function protocollo() {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $query = "SELECT id,nomeFunzione FROM funzione where nomeFunzione='Protocollo'";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $mysqli->close();
            return $row->id;
        }
    }

    public static function responsabile() {

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return null;
        }

        $query = "SELECT id,nomeFunzione FROM funzione where nomeFunzione='Responsabile'";
        $result = $mysqli->query($query);

        if ($mysqli->errno > 0) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $mysqli->close();
        } else {
            $row = $result->fetch_object();
            $mysqli->close();
            return $row->id;
        }
    }

    public static function setNewOp($nuovoOp) {

        $nomeOp = $nuovoOp->getNome();
        $cognomeOp = $nuovoOp->getCognome();
        $contattoOp = $nuovoOp->getContatto();
        $funzioneOp = $nuovoOp->getFunzione();
        $usernameOp = $nuovoOp->getUsername();
        $passwordOp = $nuovoOp->getPassword();

        $mysqli = ConnectionFactory::connetti();

        if (!isset($mysqli)) {
            return false;
        }

        $anagrafica = AnagraficaFactory::getAnagraficaByName($nomeOp, $cognomeOp, $mysqli);

        // Start transaction
        $mysqli->autocommit(false);

        if ($anagrafica < 1) {
            $anagrafica = AnagraficaFactory::setAnagrafica($nomeOp, $cognomeOp, $contattoOp, $mysqli);
        }

        if ($anagrafica < 1) {
            $mysqli->autocommit(true);
            return false;
        }

        $stmt = $mysqli->stmt_init();
        $query = "INSERT INTO operatore VALUES(default,?,?,?,?)";

        $stmt->prepare($query);
        $stmt->bind_param("issi", $funzioneOp, $usernameOp, $passwordOp, $anagrafica);
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query 
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            $mysqli->rollback();
            $mysqli->autocommit(true);
            $stmt->close();
            $mysqli->close();
            return $errore;
        } else {
            $mysqli->commit();
            $mysqli->autocommit(true);
            $stmt->close();
            $mysqli->close();
            return 0;
        }
    }

    public static function getListaOp() {
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
            return null;
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

    public static function ruolo($funzione) {
        switch ($funzione) {
            case OperatoreFactory::operatore():
                $ruolo = "operatore";
                break;
            case OperatoreFactory::protocollo():
                $ruolo = "protocollo";
                break;
            case OperatoreFactory::responsabile():
                $ruolo = "responsabile";
                break;
            case OperatoreFactory::admin():
                $ruolo = "amministratore";
                break;
        }
        return $ruolo;
    }

    public static function updateOp($nuovoOp) {

        $id = $nuovoOp->getId();
        $idAn = $nuovoOp->getIdAn();
        $nomeOp = $nuovoOp->getNome();
        $cognomeOp = $nuovoOp->getCognome();
        $contattoOp = $nuovoOp->getContatto();
        $funzioneOp = $nuovoOp->getFunzione();
        $usernameOp = $nuovoOp->getUsername();
        $passwordOp = $nuovoOp->getPassword();

        $mysqli = ConnectionFactory::connetti();
        if (!isset($mysqli)) {
            return false;
        }

        // Start transaction
        //$mysqli->autocommit(false);
//        $anagrafica = AnagraficaFactory::updateAnagrafica($idAn, $nomeOp, $cognomeOp, $contattoOp, $mysqli);
        $anagrafica = AnagraficaFactory::updateAnagrafica2($idAn, $nomeOp, $cognomeOp, $contattoOp);

        if ($anagrafica !== 1) {
//            $mysqli->autocommit(true);
            $mysqli->close();
            return false;
        }

        $stmt = $mysqli->stmt_init();

        $query = "UPDATE operatore SET funzione=?, username=?,password=? where id=?";
        $stmt->prepare($query);
        $stmt->bind_param("issi", $funzioneOp, $usernameOp, $passwordOp, $id);
        $result = $stmt->execute();

        if (!$result) {
            // errore nella esecuzione della query (es. sintassi)
            error_log("Errore nella esecuzione della query
            $mysqli->errno : $mysqli->error", 0);
            $errore = $mysqli->errno;
            //$mysqli->rollback();
            //$mysqli->autocommit(true);
            $stmt->close();
            $mysqli->close();
            return $errore;
        } else {
            //$mysqli->commit();
            //$mysqli->autocommit(true);
            $stmt->close();
            $mysqli->close();
            return 0;
        }
    }

}

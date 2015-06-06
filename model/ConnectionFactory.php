<?php

include_once 'model/Settings.php';

class ConnectionFactory {

    public static function connetti() {
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_pass, Settings::$db_name);

        if ($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("Errore nella connessione al server $idErrore : $msg", 0);
            echo "Errore nella connessione $msg";
        } else {
            return $mysqli;
        }
        return null;
    }
}
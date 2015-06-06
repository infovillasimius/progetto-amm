<?php

include_once './controller/BaseController.php';
include_once './controller/AdminController.php';
include_once './controller/ProtocolloController.php';
include_once './controller/ResponsabileController.php';
include_once './controller/OperatoreController.php';

FrontController::dispatch($_REQUEST);

class FrontController {

    /**
     * Gestore delle richieste al punto unico di accesso all'applicazione
     * @param array $request i parametri della richiesta
     */
    public static function dispatch(&$request) {
        // inizializziamo la sessione 
        session_start();

        if (!isset($request["page"])) {
            $controller = new BaseController();
            $controller->lavoraRichieste($request);
        } else {

            switch ($request["page"]) {

                case "login":
                    $controller = new BaseController();
                    $controller->lavoraRichieste($request);
                    break;

                case "logout":
                    $controller = new BaseController();
                    $controller->lavoraRichieste($request);
                    break;

                // Admin
                case 'admin':

                    $controller = new AdminController();

                    if (isset($_SESSION["op"])) {
                        $operatore = $_SESSION["op"];
                    } else {
                        self::write403();
                    }

                    if (isset($operatore) &&
                            $operatore->getFunzione() >= OperatoreFactory::admin()) {
                            $controller->lavoraRichieste($request);
                    } else {
                        self::write403();
                    } 
                    break;

                // operatore
                case 'operatore':

                    $controller = new OperatoreController();
                     if (isset($_SESSION["op"])) {
                        $operatore = $_SESSION["op"];
                    } else {
                        self::write403();
                    }

                    if (isset($operatore) &&
                            $operatore->getFunzione() >= OperatoreFactory::operatore()) {
                            $controller->lavoraRichieste($request);
                    } else {
                        self::write403();
                    } 
                    break;

                // Responsabile
                case 'responsabile':

                    $controller = new ResponsabileController();
                     if (isset($_SESSION["op"])) {
                        $operatore = $_SESSION["op"];
                    } else {
                        self::write403();
                    }

                    if (isset($operatore) &&
                            $operatore->getFunzione() >= OperatoreFactory::responsabile()) {
                            $controller->lavoraRichieste($request);
                    } else {
                        self::write403();
                    } 
                    break;

                // Protocollo
                case 'protocollo':

                    $controller = new ProtocolloController();
                    
                     if (isset($_SESSION["op"])) {
                        $operatore = $_SESSION["op"];
                    } else {
                        self::write403();
                    }

                    if (isset($operatore) &&
                            $operatore->getFunzione() >= OperatoreFactory::protocollo()) {
                            $controller->lavoraRichieste($request);
                    } else {
                        self::write403();
                    } 
                    break;
                default :
                    self::write404();
            }
        }
    }

    /**
     * Crea una pagina di errore quando il path specificato non esiste
     */
    public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        $pagina = new Struttura();
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/error.php");
        $pagina->setTitle("File non trovato!");
        $pagina->setLeftBarFile("./view/errorMenu.php");
        include "./view/masterPage.php";
        exit();
    }

    /**
     * Crea una pagina di errore quando l'utente non ha i privilegi 
     * per accedere alla pagina
     */
    public static function write403() {
        // impostiamo il codice della risposta http a 403 (forbidden)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $pagina = new Struttura();
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/error.php");
        $pagina->setTitle("Accesso negato");
        $pagina->setLeftBarFile("./view/errorMenu.php");
        include "./view/masterPage.php";
        exit();
    }

}

?>
    
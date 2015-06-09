<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';

class OperatoreController {

    public function lavoraRichieste(&$richieste) {

        $pagina = new Struttura();

        if (isset($_SESSION["op"])) {
            $operatore = $_SESSION["op"];
        }
        if (isset($richieste["cmd"])) {
            switch ($richieste["cmd"]) {

                case "elencoP":
                    self::mostraElencoP($pagina);
                    break;

                case "aggiornaP":
                    self::mostraAggiornaP($pagina);
                    break;

                case "firmaP":
                    self::mostraFirmaP($pagina);
                    break;

                case "cercaAn":
                    self::cercaAn();
                    break;

                default :
                    OperatoreController::mostraBenvenuto($pagina);
                    break;
            }
        }
    }

    /**
     * Mostra una pagina di comunicazione per i cmd errati (inseriti tramite url)
     * @param Struttura $pagina
     */
    public static function mostraBenvenuto($pagina) {
        $operatore = $_SESSION["op"];
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/benvenuto.php");
        $pagina->setTitle("Benvenuto");
        OperatoreController::setruolo($pagina);
        $pagina->setMsg('<div class="erroreInput"><p>Errore, cmd non esistente... faresti meglio a usare i menu!!! </p></div>');
        include "./view/masterPage.php";
    }

    /**
     * Imposta il menu corretto in base al ruolo
     * @param Struttura $pagina
     */
    public static function setRuolo($pagina) {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();

        switch ($ruolo) {
            case OperatoreFactory::admin():
                $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
                break;
            case OperatoreFactory::operatore():
                $pagina->setLeftBarFile("./view/operatore/menuOperatore.php");
                break;
            case OperatoreFactory::protocollo():
                $pagina->setLeftBarFile("./view/protocollo/menuProtocollo.php");
                break;
            case OperatoreFactory::responsabile():
                $pagina->setLeftBarFile("./view/responsabile/menuResponsabile.php");
                break;
            default :
                $pagina->setLeftBarFile("./view/errorMenu.php");
        }
    }

    public function mostraAggiornaP($pagina) {
        $pagina->setTitle("Aggiorna pratica");
        $pagina->setHeaderFile("./view/header.php");
        OperatoreController::setruolo($pagina);
        $pagina->setContentFile("./view/amministratore/aggiornaP.php");
        include "./view/masterPage.php";
    }

    public function cercaAn() {
        
        $nome = isset($_REQUEST["nome"])?$_REQUEST["nome"]:null;
        $cognome = isset($_REQUEST["cognome"])?$_REQUEST["cognome"]:null;
        $contatto = isset($_REQUEST["contatto"])?$_REQUEST["contatto"]:"";
        
        $idAnagrafica = AnagraficaFactory::getAnagraficaByName($nome, $cognome,null);
        if ($idAnagrafica < 1) {
            $idAnagrafica = AnagraficaFactory::setAnagrafica($nome, $cognome, $contatto,null);
        }
        if ($idAnagrafica < 1) {
            echo 'Errore';
            exit();
        }
        
        $anag = AnagraficaFactory::getAnagrafica($idAnagrafica);
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $json = array();
        $json["idAn"] = $idAnagrafica;
        $json["nomeAn"] = $anag->getNome();
        $json["cognomeAn"] = $anag->getCognome();
        $json["contattoAn"] = $anag->getContatto();
        echo json_encode($json);
    }

}

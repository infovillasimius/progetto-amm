<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';

class AdminController {

    public function lavoraRichieste(&$richieste) {

        $pagina = new Struttura();

        if (isset($_SESSION["op"])) {
            $operatore = $_SESSION["op"];
        }
        if (isset($richieste["cmd"])) {
            switch ($richieste["cmd"]) {
                case "nuovoOp":
                    self::mostraNuovoOp($pagina);
                    break;
                case "modificaOp":
                    self::mostraModificaOp($pagina);
                    break;
                case "elencoP":
                    self::mostraElencoP($pagina);
                    break;
                case "nuovaP":
                    self::mostraNuovaP($pagina);
                    break;
                case "aggiornaP":
                    self::mostraAggiornP($pagina);
                    break;
                case "firmaP":
                    self::mostraFirmaP($pagina);
                    break;
                case "salvaOp":
                    self::mostraNuovoOp($pagina);
                    break;
                default :
                    self::mostraBenvenuto($pagina);
                    break;
            }
        }
    }

    public function mostraNuovoOp($pagina) {


        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/nuovoOp.php");
        $pagina->setTitle("Nuovo operatore");
        $nuovoOp = new Operatore();

        if ($_REQUEST["cmd"] == "salvaOp") {
            $pagina->setTitle("Salvataggio operatore");
            $nomeOp = isset($_REQUEST["nomeOp"]) ? $_REQUEST["nomeOp"] : null;
            $cognomeOp = isset($_REQUEST["cognomeOp"]) ? $_REQUEST["cognomeOp"] : null;
            $contattoOp = isset($_REQUEST["contattoOp"]) ? $_REQUEST["contattoOp"] : null;
            $usernameOp = isset($_REQUEST["usernameOp"]) ? $_REQUEST["usernameOp"] : null;
            $passwordOp = isset($_REQUEST["passwordOp"]) ? $_REQUEST["passwordOp"] : null;
            $funzioneOp = isset($_REQUEST["funzioneOp"]) ? $_REQUEST["funzioneOp"] : null;
            $update = isset($_REQUEST["update"]) && $_REQUEST["update"] == true ? true : false;
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
            $idAn = isset($_REQUEST["idAn"]) ? $_REQUEST["idAn"] : null;

            $messaggio = '<div class="erroreInput"><p>Errore, per proseguire occorre: </p><ul>';
            $errori = 0;

            $setFunzione = $nuovoOp->setFunzione($funzioneOp);

            if (!($nuovoOp->setNome($nomeOp))) {
                $messaggio .= '<li>Specificare il nome</li>';
                $errori++;
            }
            if (!($nuovoOp->setCognome($cognomeOp))) {
                $messaggio .= '<li>Specificare il cognome</li>';
                $errori++;
            }
            if (!($nuovoOp->setContatto($contattoOp))) {
                $messaggio .= '<li>Specificare il contatto</li>';
                $errori++;
            }
            if (!($nuovoOp->setUsername($usernameOp))) {
                $messaggio .= '<li>Specificare lo username</li>';
                $errori++;
            }
            if (!($nuovoOp->setPassword($passwordOp))) {
                $messaggio .= '<li>Specificare la password</li>';
                $errori++;
            }

            if (!($nuovoOp->setid($id))) {
                //$messaggio .= '<li>ciao</li>';
            }
            if (!($nuovoOp->setidAn($idAn))) {
               // $messaggio .= '<li>ciao2</li>';
            }
            $messaggio .='</ul></div>';
            
            if ($errori > 0) {
                $pagina->setMsg($messaggio);
            } else if (!$update) {
                $setNewOp = OperatoreFactory::setNewOp($nuovoOp);

                if ($setNewOp == 0) {
                    $pagina->setContentFile("./view/amministratore/okNuovoOp.php");
                    $pagina->setTitle("Inserimento nuovo operatore");
                } elseif ($setNewOp == 1062) {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, Operatore già presente</p></div>');
                }
            } else {
                $updateOp = OperatoreFactory::updateOp($nuovoOp);

                if ($updateOp == 0) {
                    $pagina->setContentFile("./view/amministratore/okNuovoOp.php");
                    $pagina->setTitle("Modifica operatore");
                } elseif ($updateOp == 1062) {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, Operatore già presente</p></div>');
                } else {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, non è possibile aggiornare</p></div>');
                }
            }
        }

        include "./view/masterPage.php";
    }

    public function mostraModificaOp($pagina) {
        $pagina->setTitle("Modifica operatore");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $nuovoOp = OperatoreFactory::getOperatore($id);

            $pagina->setContentFile("./view/amministratore/nuovoOp.php");
            $update = true;
        } else {

            $pagina->setContentFile("./view/amministratore/modificaOp.php");
            $operatori = OperatoreFactory::getListaOp();
            $rows = count($operatori);
        }
        include "./view/masterPage.php";
    }

    public function mostraElencoP($pagina) {
        $pagina->setTitle("Elenco Pratiche");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/elencoP.php");
        include "./view/masterPage.php";
    }

    public function mostraNuovaP($pagina) {
        $pagina->setTitle("Nuova pratica");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/nuovaP.php");
        include "./view/masterPage.php";
    }

    public function mostraAggiornP($pagina) {
        $pagina->setTitle("Aggiorna pratica");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/aggiornaP.php");
        include "./view/masterPage.php";
    }

    public function mostraFirmaP($pagina) {
        $pagina->setTitle("Mostra pratiche alla firma");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/firmaP.php");
        include "./view/masterPage.php";
    }
    
    protected function mostraBenvenuto($pagina) {
        $operatore=$_SESSION["op"];
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/benvenuto.php");
        $pagina->setTitle("Benvenuto");   
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setMsg('<div class="erroreInput"><p>Errore, cmd non esistente... faresti meglio a usare i menu!!! </p></div>');
        include "./view/masterPage.php";
    }
           

}
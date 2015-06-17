<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';

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
                
                case "salvaOp":
                    self::mostraNuovoOp($pagina);
                    break;
                
                default :
                    OperatoreController::mostraBenvenuto($pagina);
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
            $tipo=false;

            $messaggio = '<div class="erroreInput"><p>Errore, per proseguire occorre: </p><ul>';
            $errori = 0;

            $setFunzione = $nuovoOp->setFunzione($funzioneOp);
            $setTipo=$nuovoOp->setTipol($tipo);
            
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

            $messaggio .='</ul></div>';
            
            if ($errori > 0) {
                $pagina->setMsg($messaggio);
            } else if (!$update) {
                $setNewOp = OperatoreFactory::setNewOp($nuovoOp);

                if ($setNewOp === 0) {
                    $pagina->setContentFile("./view/amministratore/okNuovoOp.php");
                    $pagina->setTitle("Inserimento nuovo operatore");
                } elseif ($setNewOp === 1062) {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, Operatore già presente</p></div>');
                }
            } else {
                $nuovoOp->setId($id);
                $nuovoOp->setIdAn($idAn);
                $updateOp = OperatoreFactory::updateOp($nuovoOp);

                if ($updateOp === 0) {
                    $pagina->setContentFile("./view/amministratore/okNuovoOp.php");
                    $pagina->setTitle("Modifica operatore");
                } elseif ($updateOp === 1062) {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, Operatore già presente</p></div>');
                } else {
                    $pagina->setMsg('<div class="erroreInput"><p>Errore, non è possibile aggiornare</p></div>');
                }
            }
        }

        include "./view/masterPage.php";
    }

    public function mostraModificaOp($pagina) {
        
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $nuovoOp = OperatoreFactory::getOperatore($id);
            $pagina->setTitle("Modifica operatore");
            $pagina->setContentFile("./view/amministratore/nuovoOp.php");
            $update = true;
        } else {
            $pagina->setTitle("Lista operatori");
            $pagina->setContentFile("./view/amministratore/modificaOp.php");
            $operatori = OperatoreFactory::getListaOp();
            $rows = count($operatori);
        }
        include "./view/masterPage.php";
    }

    public function mostraFirmaP($pagina) {
        $pagina->setTitle("Mostra pratiche alla firma");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setLeftBarFile("./view/amministratore/menuAmministratore.php");
        $pagina->setContentFile("./view/amministratore/firmaP.php");
        include "./view/masterPage.php";
    }
    
}

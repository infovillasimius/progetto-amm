<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';


class ProtocolloController {

    public function lavoraRichieste(&$richieste) {

        $pagina = new Struttura();

        if (isset($_SESSION["op"])) {
            $operatore = $_SESSION["op"];
        }
        if (isset($richieste["cmd"])) {
            switch ($richieste["cmd"]) {
                case "nuovaP":
                    self::mostraNuovaP($pagina);
                    break;
                
                default :
                    OperatoreController::mostraBenvenuto($pagina);
                    
                    break;
            }
        }
    }
    
   
    
    protected function mostraNuovaP($pagina) {
        $operatore=$_SESSION["op"];
        $pagina->setTitle("Nuova pratica");
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/contentPratica.php");
        $pagina->setJsFile("./js/contentPratica.js");
        OperatoreController::setruolo($pagina);
        $operatori = OperatoreFactory::getListaOp();
        $rows = count($operatori); 
        $pratica = new Pratica();
        include "./view/masterPage.php";
    }
    
    

}

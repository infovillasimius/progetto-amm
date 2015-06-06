<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';

class BaseController {

    public function lavoraRichieste(&$richieste) {
        
        $pagina = new Struttura();
       
        if (isset($_SESSION["op"])) {
            $operatore=$_SESSION["op"];
        }
        
        if (!isset($richieste["page"])){
            if(isset($operatore)){
                self::mostraBenvenuto($pagina);
            } else {
                self::mostraLogin($pagina);
                }  
        } else {
            
            switch ($richieste["page"]){
                
                case "login":
                    
                    $username=isset($richieste["username"]) ? $richieste["username"] : null;
                    $password=isset($richieste["password"]) ? $richieste["password"] : null;

                    $operatore = OperatoreFactory::getLoggedOP($username, $password);

                    if (isset($operatore)) {
                        $_SESSION["op"]=$operatore;
                        self::mostraBenvenuto($pagina);

                    } else {
                       $pagina->setMsg('<div class="erroreInput"><p>Errore, utente inesistente o password errata </p></div>');
                        self::mostraLogin($pagina);
                    }
                    break;
                
                case "logout":
                    self::logout($pagina);
                    self::mostraLogin($pagina);
                    break;               
            }        
        }
        
        include "./view/masterPage.php";
    }
    
    /**
     * Procedura di logout dal sistema 
     * @param type $vd il descrittore della pagina
     */
    protected function logout($vd) {
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            // imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        
    }
    
    protected function mostraLogin($pagina) {
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/login/login.php");
        $pagina->setTitle("Pagina di login");
    }
    
    protected function mostraBenvenuto($pagina) {
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/benvenuto.php");
        $pagina->setTitle("Benvenuto");
        $operatore=$_SESSION["op"];
        $ruolo=$operatore->getFunzione();
        
        switch ($ruolo){
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


}

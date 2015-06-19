<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';

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
     * @param Struttura $pagina il descrittore della pagina
     */
    protected function logout($pagina) {
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
    /**
     * Mostra la pagina di login
     * @param Struttura $pagina
     */
    protected function mostraLogin($pagina) {
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/login/login.php");
        $pagina->setTitle("Pagina di login");
    }
    
    /**
     * Mostra la pagina di benvenuto
     * @param Struttura $pagina
     */
    protected function mostraBenvenuto($pagina) {
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/benvenuto.php");
        $pagina->setTitle("Benvenuto");
        $operatore=$_SESSION["op"];
        OperatoreController::setRuolo($pagina);      
    }


}

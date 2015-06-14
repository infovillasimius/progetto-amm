<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';

class OperatoreController {

    /**
     * Gestisce le richieste relative al livello operatore
     * e, con maggiori funzionalità, le omologhe relative
     * ai livelli di accesso superiori
     * @param Array associativo $richieste
     */
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

                case "salvaP":
                    self::mostraAggiornaP($pagina);
                    break;

                case "firmaP":
                    self::mostraFirmaP($pagina);
                    break;

                case "cercaAn":
                    self::cercaAn();
                    break;
                
                case "cercaP":
                    self::cercaP();
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

    /**
     * Gestisce le fasi di salvataggio/aggiornamento pratica
     * @param Struttura $pagina
     */
    public function mostraAggiornaP($pagina) {
//        $idUpdate = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
        $idPratica = isset($_REQUEST["idPratica"]) ? $_REQUEST["idPratica"] : null;

        $operatore = $_SESSION["op"];
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/operatore/aggiornaP.php");
        $ruolo = $operatore->getFunzione();
        OperatoreController::setruolo($pagina);
        $operatori = OperatoreFactory::getListaOp();
        $rows = count($operatori);

        if ($ruolo >= 2) {
            $pagina->setJsFile("./js/contentPratica.js");
        } else {
            $pagina->setJsFile("./js/operatore.js");
        }

        if ($_REQUEST["cmd"] === "aggiornaP" && isset($_REQUEST["numeroP"])) {
            
            $numeroP = $_REQUEST["numeroP"];
            
            $idUpdate = PraticaFactory::ricercaPerNumeroPratica($numeroP);
            if($numeroP==""){
                $pagina->setMsg("Errore, inserisci il numero di una pratica esistente <br/>oppure utilizza la voce di menu [Elenco].");
            } elseif (!isset($idUpdate)){
                $pagina->setMsg("Errore, pratica N. " . $numeroP . " non presente! <br/>Inserisci il numero di una pratica esistente <br/>oppure utilizza la voce di menu [Elenco].");
            }
        }

        if (!isset($idUpdate)) {
            $pratica = new Pratica();
        } else {
            $pratica = PraticaFactory::getPraticaById($idUpdate);
            $pagina->setContentFile("./view/contentPratica.php");
            $pagina->setTitle("Aggiorna pratica");

            if (!isset($pratica)) {
                $pratica = new Pratica();
                
            }
        }

        if ($_REQUEST["cmd"] == "salvaP") {
            $pagina->setJsFile("./js/contentPratica.js");

            $contatto = isset($_REQUEST["contatto"]) ? ($_REQUEST["contatto"]) : null;
            $dataAvvioProcedimento = isset($_REQUEST["dataAvvioProcedimento"]) ? ($_REQUEST["dataAvvioProcedimento"]) : null;
            $dataCaricamento = isset($_REQUEST["dataCaricamento"]) ? ($_REQUEST["dataCaricamento"]) : null;
            $dataConferenzaServizi = isset($_REQUEST["dataConferenzaServizi"]) ? ($_REQUEST["dataConferenzaServizi"]) : null;
            $dataInvioRicevuta = isset($_REQUEST["dataInvioRicevuta"]) ? ($_REQUEST["dataInvioRicevuta"]) : null;
            $dataInvioVerifiche = isset($_REQUEST["dataInvioVerifiche"]) ? ($_REQUEST["dataInvioVerifiche"]) : null;
            $dataProtocollo = isset($_REQUEST["dataProtocollo"]) ? ($_REQUEST["dataProtocollo"]) : null;
            $dataProvvedimento = isset($_REQUEST["dataProvvedimento"]) ? ($_REQUEST["dataProvvedimento"]) : null;
            $flagAllaFirma = isset($_REQUEST["flagAllaFirma"]) ? ($_REQUEST["flagAllaFirma"]) : null;
            $flagFirmata = isset($_REQUEST["flagFirmata"]) ? ($_REQUEST["flagFirmata"]) : null;
            $flagInAttesa = isset($_REQUEST["flagInAttesa"]) ? ($_REQUEST["flagInAttesa"]) : null;
            $flagSoprintendenza = isset($_REQUEST["flagSoprintendenza"]) ? ($_REQUEST["flagSoprintendenza"]) : null;
            $importoDiritti = isset($_REQUEST["importoDiritti"]) ? ($_REQUEST["importoDiritti"]) : null;
            $incaricato = isset($_REQUEST["incaricato"]) ? ($_REQUEST["incaricato"]) : null;
            $motivoAttesa = isset($_REQUEST["motivoAttesa"]) ? ($_REQUEST["motivoAttesa"]) : null;
            $numeroPratica = isset($_REQUEST["numeroPratica"]) ? ($_REQUEST["numeroPratica"]) : null;
            $numeroProtocollo = isset($_REQUEST["numeroProtocollo"]) ? ($_REQUEST["numeroProtocollo"]) : null;
            $numeroProtocolloProvvedimento = isset($_REQUEST["numeroProtocolloProvvedimento"]) ? ($_REQUEST["numeroProtocolloProvvedimento"]) : null;
            $oggetto = isset($_REQUEST["oggetto"]) ? ($_REQUEST["oggetto"]) : null;
            $procuratore = isset($_REQUEST["procuratore"]) ? ($_REQUEST["procuratore"]) : null;
            $procuratoreId = isset($_REQUEST["procuratoreId"]) ? ($_REQUEST["procuratoreId"]) : null;
            $richiedente = isset($_REQUEST["richiedente"]) ? ($_REQUEST["richiedente"]) : null;
            $richiedenteId = isset($_REQUEST["richiedenteId"]) ? ($_REQUEST["richiedenteId"]) : null;
            $statoPratica = isset($_REQUEST["statoPratica"]) ? ($_REQUEST["statoPratica"]) : null;
            $tipoPratica = isset($_REQUEST["tipoPratica"]) ? ($_REQUEST["tipoPratica"]) : null;
            $ubicazione = isset($_REQUEST["ubicazione"]) ? ($_REQUEST["ubicazione"]) : null;

            $err = 0;

            $pratica->setContatto($contatto);
            $pratica->setDataAvvioProcedimento($dataAvvioProcedimento);
            $pratica->setDataCaricamento($dataCaricamento);
            $pratica->setDataConferenzaServizi($dataConferenzaServizi);
            $pratica->setDataInvioRicevuta($dataInvioRicevuta);
            $pratica->setDataInvioVerifiche($dataInvioVerifiche);
            if ($ruolo > 1) {
                $pratica->setDataProtocollo($dataProtocollo);
                $pratica->setFlagFirmata($flagFirmata);
                $pratica->setProcuratore($procuratore);
                if (!$pratica->setProcuratoreId($procuratoreId)) {
                    $err++;
                }
                $pratica->setRichiedente($richiedente);
                if (!$pratica->setRichiedenteId($richiedenteId)) {
                    $err++;
                }
                if (!$pratica->setIncaricato($incaricato)) {
                    $err++;
                }
                if (!$pratica->setNumeroPratica($numeroPratica)) {
                    $err++;
                }
                if (!$pratica->setNumeroProtocollo($numeroProtocollo)) {
                    $err++;
                }
                if (!$pratica->setStatoPratica($statoPratica)) {
                    $err++;
                }
                if (!$pratica->setTipoPratica($tipoPratica)) {
                    $err++;
                }
            }

            $pratica->setDataProvvedimento($dataProvvedimento);
            $pratica->setFlagAllaFirma($flagAllaFirma);
            $pratica->setFlagInAttesa($flagInAttesa);
            $pratica->setFlagSoprintendenza($flagSoprintendenza);
            $pratica->setImportoDiritti($importoDiritti);
            $pratica->setMotivoAttesa($motivoAttesa);
            $pratica->setNumeroProtocolloProvvedimento($numeroProtocolloProvvedimento);
            $pratica->setOggetto($oggetto);
            $pratica->setUbicazione($ubicazione);

            //var_dump($pratica);

            if ($idPratica == "" && $err == 0) {
                $pagina->setTitle("Salvataggio pratica");
                $errore = PraticaFactory::salvaP($pratica);
            } elseif ($err === 0) {
                $pagina->setTitle("Aggiorna pratica");
                $errore = PraticaFactory::aggiornaP($pratica);
            } else {
                $pagina->setTitle("Errore");
            }
            if ($errore == 0 && $err == 0) {
                $pagina->setContentFile("./view/operatore/okNuovaP.php");
                
            } elseif ($errore == 1062) {
                $pagina->setContentFile("./view/contentPratica.php");
                $pagina->setMsg("Errore, pratica N. " . $pratica->getNumeroPratica() . " già presente!");
            } else {
                $pagina->setContentFile("./view/contentPratica.php");
            }
        }
        
        include "./view/masterPage.php";
    }

    /**
     * Restituisce una vista json dell'anagrafica cercata
     * Se la stessa non viene trovata, viene inserita in 
     * archivio automaticamente
     */
    public function cercaAn() {

        $nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : null;
        $cognome = isset($_REQUEST["cognome"]) ? $_REQUEST["cognome"] : null;
        $contatto = isset($_REQUEST["contatto"]) ? $_REQUEST["contatto"] : "";

        $idAnagrafica = AnagraficaFactory::getAnagraficaByName($nome, $cognome, null);
        if ($idAnagrafica < 1) {
            $idAnagrafica = AnagraficaFactory::setAnagrafica($nome, $cognome, $contatto, null);
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

    public function mostraElencoP($pagina) {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();
        $pratica = new Pratica();
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setTitle("Elenco pratiche");
        OperatoreController::setruolo($pagina);
        $pagina->setMsg('');
        $pagina->setContentFile("./view/operatore/elencoP.php");
        $operatori = OperatoreFactory::getListaOp();
        $rows = count($operatori);
        include "./view/masterPage.php";
    }
    
    public function cercaP() {

        $nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : null;
        $cognome = isset($_REQUEST["cognome"]) ? $_REQUEST["cognome"] : null;
        $contatto = isset($_REQUEST["contatto"]) ? $_REQUEST["contatto"] : "";

        $idAnagrafica = AnagraficaFactory::getAnagraficaByName($nome, $cognome, null);
        if ($idAnagrafica < 1) {
            $idAnagrafica = AnagraficaFactory::setAnagrafica($nome, $cognome, $contatto, null);
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

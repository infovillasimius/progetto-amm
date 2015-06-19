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
                    self::firmaP($pagina);
                    break;

                case "cercaAn":
                    self::cercaAn();
                    break;

                case "getAn":
                    self::getAn();
                    break;

                case "ricercaAn":
                    self::ricercaAn();
                    break;

                case "cercaP":
                    self::cercaP();
                    break;
                
                case "uploadF":
                    self::uploadF($pagina);
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
        $pagina->setMsg('<div class="erroreInput"><p>Errore, pagina non esistente...</p></div>');
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
        $idUpdate = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
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
            if ($numeroP == "") {
                $pagina->setMsg("Errore, inserisci il numero di una pratica esistente <br/>oppure utilizza la voce di menu [Elenco].");
            } elseif (!isset($idUpdate)) {
                $pagina->setMsg("Errore, pratica N. " . $numeroP . " non presente! <br/>Inserisci il numero di una pratica esistente <br/>oppure utilizza la voce di menu [Elenco].");
            } elseif ($ruolo < 2) {
                $pratica = PraticaFactory::getPraticaById($idUpdate);
                if ($pratica->getIncaricato() != $operatore->getId()) {
                    unset($pratica);
                    unset($idUpdate);
                }
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
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
        $nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : null;
        $cognome = isset($_REQUEST["cognome"]) ? $_REQUEST["cognome"] : null;
        $contatto = isset($_REQUEST["contatto"]) ? $_REQUEST["contatto"] : "";
        $tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;

        $idAn = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $tipo = filter_var($tipo, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (!isset($idAn)) {
            $idAnagrafica = AnagraficaFactory::getAnagraficaByName($nome, $cognome, null);
            if ($idAnagrafica < 1) {
                $idAnagrafica = AnagraficaFactory::setAnagrafica($tipo, $nome, $cognome, $contatto, null);
            }
            if ($idAnagrafica < 1) {
                echo 'Errore';
                exit();
            }
        } else {
            AnagraficaFactory::updateAnagrafica($idAn, $tipo, $nome, $cognome, $contatto, null);
            $idAnagrafica = $idAn;
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
        $json["tipo"] = $anag->getTipol();
        echo json_encode($json);
    }

    /**
     * Mostra la pagina base per la schermata di ricerca
     * @param \Struttura $pagina
     */
    public function mostraElencoP($pagina) {
        $pagina->setJsFile("./js/ricerca.js");
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setTitle("Elenco pratiche");
        OperatoreController::setruolo($pagina);
        $pagina->setMsg('');
        $pagina->setContentFile("./view/operatore/elencoP.php");
        $operatori = OperatoreFactory::getListaOp();
        $rows = count($operatori);
        include "./view/masterPage.php";
    }

    /**
     * Restituisce un testo html , contenente le pratiche cercate, che si integra nella tabella di ricerca attrverso js
     */
    public function cercaP() {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();

        $ricerca = array();
        $ricerca["numeroPratica"] = isset($_REQUEST["numeroPratica"]) ? $_REQUEST["numeroPratica"] : null;
        $ricerca["statoPratica"] = isset($_REQUEST["statoPratica"]) ? $_REQUEST["statoPratica"] : null;
        $ricerca["tipoPratica"] = isset($_REQUEST["tipoPratica"]) ? $_REQUEST["tipoPratica"] : null;
        $ricerca["incaricato"] = isset($_REQUEST["incaricato"]) ? $_REQUEST["incaricato"] : null;
        $ricerca["flagAllaFirma"] = isset($_REQUEST["flagAllaFirma"]) ? $_REQUEST["flagAllaFirma"] : null;
        $ricerca["flagFirmata"] = isset($_REQUEST["flagFirmata"]) ? $_REQUEST["flagFirmata"] : null;
        $ricerca["flagInAttesa"] = isset($_REQUEST["flagInAttesa"]) ? $_REQUEST["flagInAttesa"] : null;
        $ricerca["flagSoprintendenza"] = isset($_REQUEST["flagSoprintendenza"]) ? $_REQUEST["flagSoprintendenza"] : null;
        $offset = isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0;
        $numero = isset($_REQUEST["numero"]) ? $_REQUEST["numero"] : 15;
        $richiestaFirmate = isset($_REQUEST["richiestaFirmate"]) ? $_REQUEST["richiestaFirmate"] : 0;

        if ($ruolo < 2) {
            $ricerca["incaricato"] = $operatore->getId();
        }

        $numeroPratiche = PraticaFactory::numeroTotalePratiche();

        if ($offset >= $numeroPratiche) {
            $offset = 0;
        }
        if ($offset < 1) {
            $offset = 0;
        }

        if ($richiestaFirmate === 0) {
            $href = '<a href="index.php?page=operatore&cmd=aggiornaP&numeroP=';
        } elseif ($ruolo > 2) {
            $href = '<a href="index.php?page=responsabile&cmd=firmaP&numeroP=';
        }

        $pratiche = PraticaFactory::elencoP($ricerca, $offset, $numero);
        $x = count($pratiche);
        $data = "";
        for ($i = 0; $i < $x; $i++) {
            $data.= "<tr class=\"" . ($i % 2 == 1 ? "a" : "b") . "\"><td>" . $href
                    . $pratiche[$i]->getNumeroPratica() . "\">" . $pratiche[$i]->getNumeroPratica() . "</a></td>"
                    . "<td>" . $pratiche[$i]->getDataCaricamento(true) . "</td>"
                    . "<td>" . $pratiche[$i]->getRichiedente() . "</td>"
                    . "<td>" . PraticaFactory::tipoPratica($pratiche[$i]->getTipoPratica()) . "</td>"
                    . "<td>" . PraticaFactory::statoPratica($pratiche[$i]->getStatoPratica()) . "</td>"
                    . "<td>" . OperatoreFactory::getOperatore($pratiche[$i]->getIncaricato())->getNominativo() . "</td>"
                    . "</tr>";
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $json = array();
        $json["testo"] = $data;
        $json["numeroPratiche"] = $numeroPratiche;
        $json["numRow"] = $x;
        echo json_encode($json);
    }

    /**
     * Restituisce una serie di <option> per select in formato json contenenti anagrafiche
     */
    public function ricercaAn() {

        $nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : null;
        $cognome = isset($_REQUEST["cognome"]) ? $_REQUEST["cognome"] : null;

        $anagrafiche = AnagraficaFactory::getListaAnagraficaByName($nome, $cognome);

        if (!isset($anagrafiche)) {
            echo 'Errore';
        }

        $x = count($anagrafiche) - 1;
        $anagraficheTrovate = $anagrafiche[0];

        $data = "";
        for ($i = 1; $i <= $x; $i++) {
            $data.='<option value="' . $anagrafiche[$i]->getId() . '">' . $anagrafiche[$i]->getNominativo() . '</option>';
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $json = array();
        $json["testo"] = $data;
        $json["trovate"] = $anagraficheTrovate;
        $json["numRow"] = $x;
        echo json_encode($json);
    }

    /**
     * Restituisce una anagrafica in formato json
     * @return type
     */
    public function getAn() {
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;

        if (!isset($id)) {
            return null;
        }
        $anagrafica = AnagraficaFactory::getAnagrafica($id);
        if (!isset($anagrafica)) {
            echo 'Errore';
            exit("Errore nella generazione dell'anagrafica");
        }
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $json = array();
        $json["id"] = $id;
        $json["nome"] = $anagrafica->getNome();
        $json["cognome"] = $anagrafica->getCognome();
        $json["tipo"] = $anagrafica->getTipol();
        $json["contatto"] = $anagrafica->getContatto();
        echo json_encode($json);
    }

    /**
     * Gestisce la procedura di caricamento dei files associati alle pratiche
     * @param Struttura $pagina
     */
    public function firmaP($pagina) {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();
        $pagina->setTitle("Firma documenti");
        $pagina->setHeaderFile("./view/header.php");

        $pagina->setJsFile("");
        OperatoreController::setruolo($pagina);
        $numeroP = isset($_REQUEST["numeroP"]) ? filter_var($_REQUEST["numeroP"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) : null;
        if (isset($numeroP)) {
            
            $pratica = PraticaFactory::getPraticaById(PraticaFactory::ricercaPerNumeroPratica($numeroP));
            $opPratica = $pratica->getIncaricato();
        } else {
            $pagina->setMsg('<div class="erroreInput"><p>Errore, nessuna pratica selezionata!!! </p></div>');
            self::mostraErrore($pagina);
            exit();
        }
        if ($operatore->getId() != $opPratica && $ruolo<3) {
            
            $pagina->setMsg('<div class="erroreInput"><p>La pratica è assegnata ad altro operatore!!! </p></div>');
            self::mostraErrore($pagina);
            exit();
        }
        if (!is_dir('./files/uploads/' . $numeroP)) {
            if (!mkdir('./files/uploads/' . $numeroP, 0777)) {
                die('Failed to create folders...');
            }
            chmod('./files/uploads/' . $numeroP, 0777);
        }
        $pagina->setContentFile("./view/responsabile/carica.php");
        include "./view/masterPage.php";
    }

    /**
     * Carica un file sul server e visualizza contenuto cartella associata alla pratica
     * @param Struttura $pagina
     */
    public function uploadF($pagina) {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();
        $pagina->setTitle("Salvataggio documenti");
        $pagina->setHeaderFile("./view/header.php");

        $pagina->setJsFile("");
        OperatoreController::setruolo($pagina);

        if (!isset($_REQUEST["numeroP"])) {
            $pagina->setMsg('<div class="erroreInput"><p>Errore, nessuna pratica selezionata!!! </p></div>');
            self::mostraErrore($pagina);
            exit();
        } else {
            $numeroP = isset($_REQUEST["numeroP"]) ? $_REQUEST["numeroP"] : null;
            $target_dir = './files/uploads/' . $numeroP . '/';
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $msg = "";
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $msg.="Il file è troppo grande. ";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($fileType != "pdf" && $fileType != "p7m") {
                $msg.= "Sono ammessi solo PDF e P7M. ";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg.= " Il file non è stato caricato. ";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $msg.= " Il File " . basename($_FILES["fileToUpload"]["name"]) . " è stato caricato. ";
                } else {
                    $msg.= " Spiacenti, si è verificato un errore. ";
                }
            }
            $pagina->setMsg($msg);
            $pagina->setContentFile("./view/responsabile/carica.php");
        }

        include "./view/masterPage.php";
    }

    /**
     * Mostra la pagina relativa all'errore occorso
     * @param Struttura $pagina
     */
    protected function mostraErrore($pagina) {
        $operatore = $_SESSION["op"];
        $pagina->setContentFile("./view/benvenuto.php");
        $pagina->setTitle("Errore");
        OperatoreController::setruolo($pagina);
        include "./view/masterPage.php";
    }

}

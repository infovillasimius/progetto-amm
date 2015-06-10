<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';

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

                case "salvaP":
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

        $operatore = $_SESSION["op"];
        $pagina->setHeaderFile("./view/header.php");
        $pagina->setContentFile("./view/contentPratica.php");
        $pagina->setJsFile("./js/contentPratica.js");

        OperatoreController::setruolo($pagina);
        $operatori = OperatoreFactory::getListaOp();
        $rows = count($operatori);
        $pratica = new Pratica();



        if ($_REQUEST["cmd"] == "salvaP") {

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



            $pratica->setContatto($contatto);
            $pratica->setDataAvvioProcedimento($dataAvvioProcedimento);
            $pratica->setDataCaricamento($dataCaricamento);
            $pratica->setDataConferenzaServizi($dataConferenzaServizi);
            $pratica->setDataInvioRicevuta($dataInvioRicevuta);
            $pratica->setDataInvioVerifiche($dataInvioVerifiche);
            $pratica->setDataProtocollo($dataProtocollo);
            $pratica->setDataProvvedimento($dataProvvedimento);
            $pratica->setFlagAllaFirma($flagAllaFirma);
            $pratica->setFlagFirmata($flagFirmata);
            $pratica->setFlagInAttesa($flagInAttesa);
            $pratica->setFlagSoprintendenza($flagSoprintendenza);
            $pratica->setImportoDiritti($importoDiritti);
            $pratica->setIncaricato($incaricato);
            $pratica->setMotivoAttesa($motivoAttesa);
            $pratica->setNumeroPratica($numeroPratica);
            $pratica->setNumeroProtocollo($numeroProtocollo);
            $pratica->setNumeroProtocolloProvvedimento($numeroProtocolloProvvedimento);
            $pratica->setOggetto($oggetto);
            $pratica->setProcuratore($procuratore);
            $pratica->setProcuratoreId($procuratoreId);
            $pratica->setRichiedente($richiedente);
            $pratica->setRichiedenteId($richiedenteId);
            $pratica->setStatoPratica($statoPratica);
            $pratica->setTipoPratica($tipoPratica);
            $pratica->setUbicazione($ubicazione);



            if ($_REQUEST["idPratica"] == "") {
                $pagina->setTitle("Salvataggio pratica");
                $errore = PraticaFactory::salvaP($pratica);
                if ($errore == 0) {
                    $pagina->setContentFile("./view/operatore/aggiornaP.php");
                } else {
                    $pagina->setContentFile("./view/contentPratica.php");
                }
            } else {
                $pagina->setTitle("Aggiorna pratica");
            }
        }
        //$pagina->setContentFile("./view/operatore/aggiornaP.php");
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

}

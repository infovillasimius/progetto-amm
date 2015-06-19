<?php

include_once './view/Struttura.php';
include_once './model/Pratica.php';
include_once './model/Anagrafica.php';
include_once './model/Operatore.php';
include_once './model/OperatoreFactory.php';
include_once './model/AnagraficaFactory.php';
include_once './model/PraticaFactory.php';

class ResponsabileController {

    public function lavoraRichieste(&$richieste) {

        $pagina = new Struttura();

        if (isset($_SESSION["op"])) {
            $operatore = $_SESSION["op"];
        }
        if (isset($richieste["cmd"])) {
            switch ($richieste["cmd"]) {
                case "firmaP":
                    self::firmaP($pagina);
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
     * Gestisce la scelta della pratica su cui operare
     * per eseguire la firma digitale dei files allegati
     * @param Struttura $pagina
     */
    public function firmaP($pagina) {
        $operatore = $_SESSION["op"];
        $ruolo = $operatore->getFunzione();
        $pagina->setTitle("Firma documenti");
        $pagina->setHeaderFile("./view/header.php");

        $pagina->setJsFile("./js/allaFirma.js");
        OperatoreController::setruolo($pagina);

        if (!isset($_REQUEST["numeroP"])) {
            $pagina->setContentFile("./view/responsabile/sceltaP.php");
        } else {
            $numeroP = isset($_REQUEST["numeroP"]) ? $_REQUEST["numeroP"] : null;

            if (!is_dir('./files/uploads/' . $numeroP)) {
                if (!mkdir('./files/uploads/' . $numeroP, 0777)) {
                    die('Failed to create folders...');
                }
                chmod('./files/uploads/' . $numeroP, 0777);
            }

            $pagina->setContentFile("./view/responsabile/carica.php");
        }

        include "./view/masterPage.php";
    }

    /**
     * Carica un file e visualizza contenuto cartella associata alla pratica
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
            $pagina->setContentFile("./view/responsabile/sceltaP.php");
        } else {
            $numeroP = isset($_REQUEST["numeroP"]) ? $_REQUEST["numeroP"] : null;
            $target_dir = './files/uploads/' . $numeroP . '/';
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $msg="";
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
     * Effettua la scansione di una cartella e genera elenco navigabile delle entry
     * @param string $Directory
     */
    public static function ScanDirectory($Directory) {

        $MyDirectory = opendir($Directory) or die('Error');
        while ($Entry = readdir($MyDirectory)) {
            if (is_dir($Directory . '/' . $Entry) && $Entry != '.' && $Entry != '..') {
                echo '<ul>' . $Directory;
                ScanDirectory($Directory . '/' . $Entry);
                echo '</ul>';
            } elseif ($Entry == '.' || $Entry == '..') {
                
            } else {
                $file = glob($Directory . '/' . $Entry);
                echo '<li><a href="' . $file[0] . '">' . $Entry . '</a></li>';
            }
        }
        closedir($MyDirectory);
    }

}

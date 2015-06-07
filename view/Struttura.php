<?php

/**
 * Classe Struttura
 * contiene la definizione delle parti della struttura delle pagine
 * relativamente ai diversi contenuti da mostrare
 */
class Struttura {

    private $headerFile="./view/header.php";
    private $menuFile="./view/menu.php";
    private $leftBarFile="./view/leftBar.php";
    private $contentFile="./view/blank.php";
    private $rightBarFile="./view/rightBar.php";
    private $clearFile="./view/clear.php";
    private $footerFile="./view/footer.php";
    private $title="S.U.A.P. Unione Comuni del Sarrabus";
    private $title2;
    private $msg;
    private $jsFile;

    /**
     * Imposta il nome del file per l'header
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setHeaderFile($fileName) {
        $this->headerFile = $fileName;
        return $this->headerFile != null;
    }

    /**
     * Restituisce il nome del file per l'header
     * @return string nome file da utilizzare per l'header
     */
    public function getHeaderFile() {
        return $this->headerFile;
    }

    /**
     * Imposta il nome del file per il menù
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setMenuFile($fileName) {
        $this->menuFile = $fileName;
        return $this->menuFile != null;
    }
    
    /**
     * Restituisce il nome del file per il menu
     * @return string nome file da utilizzare per il menu
     */
    public function getMenuFile() {
        return $this->menuFile;
    }
    
    /**
     * Imposta il nome del file per la colonna sinistra
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setLeftBarFile($fileName) {
        $this->leftBarFile = $fileName;
        return $this->leftBarFile != null;
    }
    
    /**
     * Restituisce il nome del file per la colonna sinistra
     * @return string nome file da utilizzare per la colonna sinistra
     */
    public function getLeftBarFile() {
        return $this->leftBarFile;
    }
    
     /**
     * Imposta il nome del file per i contenuti della pagina
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setContentFile($fileName) {
        $this->contentFile = $fileName;
        return $this->contentFile != null;
    }
    
    /**
     * Restituisce il nome del file per i contenuti della pagina
     * @return string nome file da utilizzare per i contenuti della pagina
     */
    public function getContentFile() {
        return $this->contentFile;
    }
    
    /**
     * Imposta il nome del file per la colonna destra
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setRightBarFile($fileName) {
        $this->rightBarFile = $fileName;
        return $this->rightBarFile != null;
    }
    
    /**
     * Restituisce il nome del file per la colonna destra
     * @return string nome file da utilizzare per la colonna destra
     */
    public function getRightBarFile() {
        return $this->rightBarFile;
    }
    
    /**
     * Imposta il nome del file per la striscia sotto ai contenuti
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setClearFile($fileName) {
        $this->clearFile = $fileName;
        return $this->clearFile != null;
    }
    
    /**
     * Restituisce il nome del file per la striscia sotto ai contenuti
     * @return string nome file da utilizzare per la striscia sotto ai contenuti
     */
    public function getClearFile() {
        return $this->clearFile;
    }
    
    /**
     * Imposta il nome del file per il footer
     * @param string $fileName
     * @return boolean true se impostato correttamente
     */
    public function setFooterFile($fileName) {
        $this->footerFile = $fileName;
        return $this->footerFile != null;
    }
    
    /**
     * Restituisce il nome del file per il footer
     * @return string nome file da utilizzare per il footer
     */
    public function getFooterFile() {
        return $this->footerFile;
    }
    
    /**
     * Imposta il titolo della pagina
     * @param string $nome
     */
    public function setTitle($nome) {
        $this->title2=$nome;
    }
    
    /**
     * Restituisce il titolo della pagina
     * @return string
     */
    public function getTitle() {
        return $this->title." - ".$this->title2;
    }
    
    /**
     * Imposta il messaggio da visualizzare
     * @param string $msg
     */
    public function setMsg($msg) {
        $this->msg=$msg;
    }
    
    /**
     * Restituisce il messaggio da visualizzare
     * @return string
     */
    public function getMsg() {
        return $this->msg;
    }
    
    /**
     * Imposta il nome del file contenente lo script
     * @param string $filename
     * @return boolean True se impostato correttamente
     */
    public function setJsFile($filename) {
        $this->jsFile = $filename;
        return $this->jsFile != null;
    }
    
    /**
     * Restituisce il nome del file contenente lo script da caricare
     * @return string
     */
    public function getJsFile() {
        return $this->jsFile;
    }

}

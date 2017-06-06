<?php
include_once './model/ProvvedimentoFactory.php';
?>
<div class="nuovoOp">
    <h3>Inserimento / modifica Provvedimento</h3>
    <form method="post" action="index.php?page=operatore&amp;cmd=salvaProvvedimento">
        <label for="numeroProvvedimento">Numero Provvedimento</label>
        <input type="text" id="numeroProvvedimento" name="numeroProvvedimento" value="<?= $nuovoProvvedimento->getNumeroProvvedimento() ?>"/>
        <br/><br/>
        <label for="dataProvvedimento">Data Provvedimento</label>
        <input type="text" id="dataProvvedimento" name="dataProvvedimento" value="<?= $nuovoProvvedimento->getDataProvvedimento(true) ?>"/>
        <br/><br/>
        <label for="numeroProtocollo">Protocollo</label>
        <input type="text" id="numeroProtocollo" name="numeroProtocollo" value="<?= $nuovoProvvedimento->getNumeroProtocollo() ?>"/>
        <br/><br/>
        <label for="dataProtocollo">Data Protocollo</label>
        <input type="text" id="dataProtocollo" name="dataProtocollo" value="<?= $nuovoProvvedimento->getDataProtocollo(true) ?>"/>
        <br/><br/>
        <label for="praticaCollegata">Pratica Collegata</label>
        <input type="text" id="praticaCollegata" name="praticaCollegata" value="<?= $nuovoProvvedimento->getPraticaCollegata() ?>"/>
        
        <button type="submit" id="salvaP">Salva</button>
        <input type="hidden" name="update" value="<?= isset($update)?$update:null ?>"/>
        <input type="hidden" name="id" value="<?= $nuovoProvvedimento->getId() ?>"/>
        
    </form>
    <p><?php echo $pagina->getMsg(); ?></p>

</div>

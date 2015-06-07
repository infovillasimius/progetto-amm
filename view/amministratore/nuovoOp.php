<?php
include_once './model/OperatoreFactory.php';
?>
<div class="nuovoOp">
    <h3>Inserimento / modifica Operatore</h3>
    <form method="post" action="index.php?page=admin&cmd=salvaOp">
        <label for="nomeOp">Nome</label>
        <input type="text" id="nomeOp" name="nomeOp" value="<?= $nuovoOp->getNome() ?>"/>
        <br/>
        <label for="cognomeOp">Cognome</label>
        <input type="text" id="cognomeOp" name="cognomeOp" value="<?= $nuovoOp->getCognome() ?>"/>
        <br/>
        <label for="contattoOp">Contatto</label>
        <input type="text" id="contattoOp" name="contattoOp" value="<?= $nuovoOp->getContatto() ?>"/>
        <br/><br/>
        <label for="funzioneOp">Funzione assegnata</label>
        <select id="funzioneOp" name="funzioneOp">
            <option value="<?= OperatoreFactory::operatore() ?>" <?= $nuovoOp->getFunzione() == OperatoreFactory::operatore() ? 'selected="selected"' : "" ?>>
                Operatore
            </option>
            <option value="<?= OperatoreFactory::protocollo() ?>" <?= $nuovoOp->getFunzione() == OperatoreFactory::protocollo() ? 'selected="selected"' : "" ?>>
                Protocollo
            </option>
            <option value="<?= OperatoreFactory::responsabile() ?>" <?= $nuovoOp->getFunzione() == OperatoreFactory::responsabile() ? 'selected="selected"' : "" ?>>
                Responsabile
            </option>
            <option value="<?= OperatoreFactory::admin() ?>" <?= $nuovoOp->getFunzione() == OperatoreFactory::admin() ? 'selected="selected"' : "" ?>>
                Amministratore
            </option>
        </select>
        <br/>
        <label for="usernameOp">Username</label>
        <input type="text" id="usernameOp" name="usernameOp" value="<?= $nuovoOp->getUsername() ?>"/>
        <br/>
        <label for="passwordOp">Password</label>
        <input type="password" id="passwordOp" name="passwordOp" value="<?= $nuovoOp->getPassword() ?>"/>
        <button type="submit" id="salvaOp">Salva</button>
        <input type="hidden" name="update" value="<?= isset($update)?$update:null ?>"/>
        <input type="hidden" name="id" value="<?= $nuovoOp->getId() ?>"/>
        <input type="hidden" name="idAn" value="<?= $nuovoOp->getIdAn() ?>"/>
    </form>
    <p><?php echo $pagina->getMsg(); ?></p>

</div>

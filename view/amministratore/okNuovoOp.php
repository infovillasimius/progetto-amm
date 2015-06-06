<div class="okNuovoOp">
    
    <h4>Esito operazione</h4>
    
    <p>L'operatore <b><?= $nuovoOp->getNominativo() ?></b></p>
    <p>è stato inserito/aggiornato correttamente</p>    
    <p>con nome utente= <b><?= $nuovoOp->getUsername() ?></b></p>
    <p>password=<b><?= $nuovoOp->getPassword() ?></b>
    <p>e funzione di <b><?= OperatoreFactory::ruolo($nuovoOp->getFunzione()) ?></b></p>
    
</div>

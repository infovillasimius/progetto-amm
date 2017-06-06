<div class="input-form">
    <h3>Dati della pratica</h3>
    <form id="input" method="post" action="index.php?page=operatore&amp;cmd=salvaP">

        <div class="left">
            <label for="statoPratica">Stato pratica</label>
            <select id="statoPratica" name="statoPratica">
                <option value="0">Seleziona stato pratica</option>
                <option value="1" <?= $pratica->getStatoPratica() == "1" ? 'selected="selected"' : "" ?> >Caricata su Sardegna Suap</option>
                <option value="2" <?= $pratica->getStatoPratica() == "2" ? 'selected="selected"' : "" ?> >Protocollata</option>
                <option value="3" <?= $pratica->getStatoPratica() == "3" ? 'selected="selected"' : "" ?> >Assegnata a operatore</option>
                <option value="4" <?= $pratica->getStatoPratica() == "4" ? 'selected="selected"' : "" ?> >In attesa di Verifica formale</option>
                <option value="5" <?= $pratica->getStatoPratica() == "5" ? 'selected="selected"' : "" ?> >In attesa di Avvio procedimento</option>
                <option value="6" <?= $pratica->getStatoPratica() == "6" ? 'selected="selected"' : "" ?> >In attesa di Rilascio ricevuta</option>
                <option value="7" <?= $pratica->getStatoPratica() == "7" ? 'selected="selected"' : "" ?> >In attesa di Invio per verifiche ad enti terzi</option>
                <option value="8" <?= $pratica->getStatoPratica() == "8" ? 'selected="selected"' : "" ?> >In attesa di integrazioni rich. da enti terzi</option>
                <option value="9" <?= $pratica->getStatoPratica() == "9" ? 'selected="selected"' : "" ?> >Conferenza servizi -> Attesa pareri</option>
                <option value="10" <?= $pratica->getStatoPratica() == "10" ? 'selected="selected"' : "" ?> >Conferenza servizi -> Convocata</option>
                <option value="11" <?= $pratica->getStatoPratica() == "11" ? 'selected="selected"' : "" ?> >Conferenza servizi -> Aperta</option>
                <option value="12" <?= $pratica->getStatoPratica() == "12" ? 'selected="selected"' : "" ?> >Conferenza servizi -> Verbalizzata</option>
                <option value="13" <?= $pratica->getStatoPratica() == "13" ? 'selected="selected"' : "" ?> >Conferenza servizi -> Provvedimento unico</option>
                <option value="14" <?= $pratica->getStatoPratica() == "14" ? 'selected="selected"' : "" ?> >Chiusa -> Esito Positivo</option>
                <option value="15" <?= $pratica->getStatoPratica() == "15" ? 'selected="selected"' : "" ?> >Chiusa -> Archiviata</option>
            </select>

            <br/>
            <label for="tipoPratica">Tipo pratica</label>
            <select id="tipoPratica" name="tipoPratica">
                <option value="0">Seleziona tipo pratica</option>
                <option value="1" <?= $pratica->getTipoPratica() == "1" ? 'selected="selected"' : "" ?> >Immediato avvio - 0 gg</option>
                <option value="2" <?= $pratica->getTipoPratica() == "2" ? 'selected="selected"' : "" ?> >Immediato avvio - 20 gg</option>
                <option value="3" <?= $pratica->getTipoPratica() == "3" ? 'selected="selected"' : "" ?> >Conferenza di Servizi</option>
            </select>
            <br/>
            <label for="suap">Ufficio SUAP</label>
            <select id="suap" name="suap">
                <option value="0">Seleziona Ufficio SUAP</option>
                <option value="1" <?= $pratica->getSuap() == "1" ? 'selected="selected"' : "" ?> >Castiadas</option>
                <option value="2" <?= $pratica->getSuap() == "2" ? 'selected="selected"' : "" ?> >Muravera</option>
                <option value="3" <?= $pratica->getSuap() == "3" ? 'selected="selected"' : "" ?> >San Vito</option>
                <option value="4" <?= $pratica->getSuap() == "4" ? 'selected="selected"' : "" ?> >Villaputzu</option>
                <option value="5" <?= $pratica->getSuap() == "5" ? 'selected="selected"' : "" ?> >Villasimius</option>
            </select>
            <br/>
            <label for="numeroPratica">Numero pratica</label>
            <input type="text" id="numeroPratica" name="numeroPratica" value="<?= $pratica->getNumeroPratica(); ?>" <?= $ruolo < 2 ? "readonly" : "" ?> />
            <br/>
            <label for="dataCaricamento">Caricata in data</label>
            <input type="text" id="dataCaricamento" name="dataCaricamento" value="<?= $pratica->getDataCaricamento(true); ?>"/>
            <br/>
            <label for="numeroProtocollo">Protocollo</label>
            <input type="text" id="numeroProtocollo" name="numeroProtocollo" value="<?= $pratica->getNumeroProtocollo(); ?>" <?= $ruolo < 2 ? "readonly" : "" ?> />
            <br/>
            <label for="dataProtocollo">Data protocollo</label>
            <input type="text" id="dataProtocollo" name="dataProtocollo" value="<?= $pratica->getDataProtocollo(true); ?>" <?= $ruolo < 2 ? "readonly" : "" ?> />
            <br/>
            <label for="richiedente">Richiedente</label>
            <input type="hidden" id="richiedenteId" name="richiedenteId" value="<?= $pratica->getRichiedenteId(); ?>" />
            <input type="text" id="richiedente" name="richiedente" value="<?= $pratica->getRichiedente(); ?>" <?= $ruolo < 4 ? "readonly" : "" ?> />
            <br/>
            <label for="procuratore">Procuratore</label>
            <input type="hidden" id="procuratoreId" name="procuratoreId" value="<?= $pratica->getProcuratoreId(); ?>"/>
            <input type="text" id="procuratore" name="procuratore" value="<?= $pratica->getProcuratore(); ?>" <?= $ruolo < 4 ? "readonly" : "" ?> />
            <br/>
            <label for="contatto">Contatto</label>
            <input type="text" id="contatto" name="contatto" value="<?= $pratica->getContatto(); ?>"/>
            <br/>
            <label for="oggetto">Oggetto</label>
            <textarea id="oggetto" name="oggetto" ><?= $pratica->getOggetto(); ?></textarea>
            <br/>
            <label for="ubicazione">Ubicazione</label>
            <input type="text" id="ubicazione" name="ubicazione" value="<?= $pratica->getUbicazione(); ?>"/>
            <br/> 
            <label for="importoDiritti">Importo diritti SUAP</label>
            <input type="text" id="importoDiritti" name="importoDiritti" value="<?= $pratica->getImportoDiritti(); ?>"/>

        </div>
        <br/>
        <div class="right">
            <label for="incaricato">Operatore incaricato</label>
            <select id="incaricato" name="incaricato" <?= $ruolo < 2 ? "disabled" : "" ?>>
                <option value="0" >Selezionare operatore</option>
                <?php
                for ($x = 0; $x < $rows; $x++) {
                    if ($operatori[$x]->getFunzione() <= OperatoreFactory::protocollo()) {
                        echo '<option value="' . $operatori[$x]->getId() . '" ' .
                        ($pratica->getIncaricato() == $operatori[$x]->getId() ? 'selected="selected"' : " ") .
                        '>' . $operatori[$x]->getNominativo() . '</option>';
                    }
                }
                ?>
            </select>
            <br/>
            <label for="dataAvvioProcedimento">Data avvio procedimento</label>
            <input type="text" id="dataAvvioProcedimento" name="dataAvvioProcedimento" value="<?= $pratica->getDataAvvioProcedimento(true); ?>"/>
            <br/>
            <label for="dataInvioVerifiche">Data invio verifiche</label>
            <input type="text" id="dataInvioVerifiche" name="dataInvioVerifiche" value="<?= $pratica->getDataInvioVerifiche(true); ?>"/>
            <br/>
            <label for="dataInvioRicevuta">Data invio ricevuta</label>
            <input type="text" id="dataInvioRicevuta" name="dataInvioRicevuta" value="<?= $pratica->getDataInvioRicevuta(true); ?>"/>
            <br/>
            <label for="dataConferenzaServizi">Data Conferenza Servizi</label>
            <input type="text" id="dataConferenzaServizi" name="dataConferenzaServizi" value="<?= $pratica->getDataConferenzaServizi(true); ?>"/>
            <br/>
            <label for="dataProvvedimento">Data Provvedimento</label>
            <input type="text" id="dataProvvedimento" name="dataProvvedimento" value="<?= $pratica->getDataProvvedimento(true); ?>"/>
            <br/>
            <label for="numeroProtocolloProvvedimento">Protocollo provvedimento</label>
            <input type="text" id="numeroProtocolloProvvedimento" name="numeroProtocolloProvvedimento" value="<?= $pratica->getNumeroProtocolloProvvedimento(); ?>"/>
            <br/><br/>
            <label for="flagAllaFirma">Alla firma</label>
            <input type="checkbox" id="flagAllaFirma" name="flagAllaFirma" <?= $pratica->getFlagAllaFirma() ? 'checked="checked"' : "" ?> />
            <br/>
            <label for="flagFirmata">Firmata</label>
            <input type="checkbox" id="flagFirmata" name="flagFirmata" <?= $pratica->getFlagFirmata() ? 'checked="checked"' : "" ?> <?= $ruolo < 2 ? "disabled" : "" ?> />
            <br/>
            <label for="flagSoprintendenza">Coinvolge Soprintendenza</label>
            <input type="checkbox" id="flagSoprintendenza" name="flagSoprintendenza" <?= $pratica->getFlagSoprintendenza() ? 'checked="checked"' : "" ?> />
            <br/>
            <label for="flagInAttesa">In attesa</label>
            <input type="checkbox" id="flagInAttesa" name="flagInAttesa" <?= $pratica->getFlagInAttesa() ? 'checked="checked"' : "" ?> />
            <br/>
            <label for="motivoAttesa">Motivo dell'attesa</label>
            <textarea id="motivoAttesa" name="motivoAttesa" ><?= $pratica->getMotivoAttesa(); ?></textarea>
            <br/>
        </div>
        <input type="hidden" id="idPratica" name="idPratica" value="<?= $pratica->getId() ?>" />
        <input type="hidden" id="id" name="id" value="<?= isset($idUpdate) ? $idUpdate : null ?>" />
        <button type="submit" id="salva" value="pratica">Salva</button>
        <br/>
    </form>
    <form method="post" action="index.php?page=operatore&amp;cmd=firmaP" >
        <input type="hidden" id="numeroP" name="numeroP" value="<?= $pratica->getNumeroPratica()?>"/>
        <button id="allaFirma" type="submit">Alla firma</button>
    </form>

    <div class="none">
        <h3>Ricerca anagrafica</h3>
        <label for="ricerca">Ricerca (Cognome/Rag.Sociale)</label>
        <input type="text" id="ricerca" name="ricerca" />
        <br/><br/>
        <label for="lista">Seleziona</label>
        <select id="lista" name="lista" size="5">   
        </select>
        <h3>Inserimento anagrafica</h3>
        <form id="anagrafica" method="post" action="index.php">
            <label for="tipo">Tipo anagrafica</label>
            <select id="tipo" name="tipo">
                <option value="0">Persona Fisica</option>
                <option value="1">Persona Giuridica</option>               
            </select>
            <br/>
            <label class="nomeAn" for="nomeAn">Nome</label>
            <input class="nomeAn" type="text" id="nomeAn" name="nomeAn" value=""/>
            <br/>
            <label id="lcognome" for="cognomeAn">Cognome</label>
            <input type="text" id="cognomeAn" name="cognomeAn" value=""/>
            <br/>
            <label for="contattoAn">Contatto</label>
            <input type="text" id="contattoAn" name="contattoAn" value=""/>
            <br/>
            <input type="hidden" id="idAn" name="idAn" value=""/>
            <p class="buttons">
                <button type="submit" id="assegna" >Assegna</button>
                <button type="submit" id="salvaAn" >Salva</button>
                <button type="submit" id="chiudi" >Chiudi</button>   
            </p>
            <p id="result"></p> 
        </form>
        
    </div>
    <p id="msg" class="msg"><?php echo $pagina->getMsg(); ?></p>
</div>


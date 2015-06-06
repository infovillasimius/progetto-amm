<div class="input-form">
    <h3>Dati della pratica</h3>
    <form method="post" action="index.php?page=operatore&cmd=salvaP">
   
        <div class="left">
            <label for="statoPratica">Stato pratica</label>
            <select id="statoPratica" name="statoPratica">
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
                <option value="1" <?= $pratica->getTipoPratica() == "1" ? 'selected="selected"' : "" ?> >Immediato avvio - 0 gg</option>
                <option value="2" <?= $pratica->getTipoPratica() == "2" ? 'selected="selected"' : "" ?> >Immediato avvio - 20 gg</option>
                <option value="3" <?= $pratica->getTipoPratica() == "3" ? 'selected="selected"' : "" ?> >Conferenza di Servizi</option>
            </select>
            <br/>
            <br/>
        
            <label for="numeroPratica">Numero pratica</label>
            <input type="text" id="numeroPratica" name="numeroPratica" value="<?php $pratica->getNumeroPratica(); ?>"/>
            <br/>
            <label for="dataCaricamento">Caricata in data</label>
            <input type="text" id="dataCaricamento" name="dataCaricamento" value="<?php $pratica->getDataCaricamento(); ?>"/>
            <br/>
            <label for="numeroProtocollo">Protocollo</label>
            <input type="text" id="numeroProtocollo" name="numeroProtocollo" value="<?php $pratica->getNumeroProtocollo(); ?>"/>
            <br/>
            <label for="dataProtocollo">Data protocollo</label>
            <input type="text" id="dataProtocollo" name="dataProtocollo" value="<?php $pratica->getDataProtocollo(); ?>"/>
            <br/>
            <label for="richiedente">Richiedente</label>
            <input type="text" id="richiedente" name="richiedente" value="<?php $pratica->getRichiedente(); ?>"/>
            <br/>
            <label for="richiedente">Procuratore</label>
            <input type="text" id="procuratore" name="procuratore" value="<?php $pratica->getProcuratore(); ?>"/>
            <br/>
            <label for="richiedente">Contatto</label>
            <input type="text" id="contatto" name="contatto" value="<?php $pratica->getContatto(); ?>"/>
            <br/>
            <label for="oggetto">Oggetto</label>
            <textarea id="oggetto" name="oggetto" ><?php $pratica->getOggetto(); ?></textarea>
            <br/>
            <label for="ubicazione">Ubicazione</label>
            <input type="text" id="ubicazione" name="ubicazione" value="<?php $pratica->getUbicazione(); ?>"/>
            <br/> 
            <label for="importoDiritti">Importo diritti SUAP</label>
            <input type="text" id="importoDiritti" name="importoDiritti" value="<?php $pratica->getImportoDiritti(); ?>"/>
            
        </div>
        <br/>
        <div class="right">
            <label for="incaricato">Operatore incaricato</label>
            <select id="incaricato" name="incaricato">
                <option value="0" >Selezionare operatore</option>
                <?php           
                    for($x=0;$x<$rows;$x++){
                        if($operatori[$x]->getFunzione()<=OperatoreFactory::protocollo()){
                            echo '<option value="'.$operatori[$x]->getId().'" '.
                                    ($pratica->getIncaricato()==$operatori[$x]->getId()?'selected="selected"' : " ").
                                    '>'.$operatori[$x]->getNominativo().'</option>';
                        }
                    }
                ?>
            </select>
            <br/>
            <label for="dataAvvioProcedimento">Data avvio procedimento</label>
            <input type="text" id="dataAvvioProcedimento" name="dataAvvioProcedimento" value="<?php $pratica->getDataAvvioProcedimento(); ?>"/>
            <br/>
            <label for="dataInvioRicevuta">Data invio ricevuta</label>
            <input type="text" id="dataInvioRicevuta" name="dataInvioRicevuta" value="<?php $pratica->getDataInvioRicevuta(); ?>"/>
            <br/>
            <label for="dataInvioVerifiche">Data invio verifiche</label>
            <input type="text" id="dataInvioVerifiche" name="dataInvioVerifiche" value="<?php $pratica->getDataInvioVerifiche(); ?>"/>
            <br/>
            <label for="dataConferenzaServizi">Data Conferenza Servizi</label>
            <input type="text" id="dataConferenzaServizi" name="dataConferenzaServizi" value="<?php $pratica->getDataConferenzaServizi(); ?>"/>
            <br/>
            <label for="dataProvvedimento">Data Provvedimento</label>
            <input type="text" id="dataProvvedimento" name="dataProvvedimento" value="<?php $pratica->getDataProvvedimento(); ?>"/>
            <br/>
            <label for="numeroProtocolloProvvedimento">Protocollo provvedimento</label>
            <input type="text" id="numeroProtocolloProvvedimento" name="numeroProtocolloProvvedimento" value="<?php $pratica->getNumeroProtocolloProvvedimento(); ?>"/>
            <br/><br/>
            <label for="flagAllaFirma">Alla firma</label>
            <input type="checkbox" id="flagAllaFirma" name="flagAllaFirma" <?= $pratica->getFlagAllaFirma() ? 'checked="checked"' : "" ?> value="true"/>
            <br/>
            <label for="flagFirmata">Firmata</label>
            <input type="checkbox" id="flagFirmata" name="flagFirmata" <?= $pratica->getFlagFirmata() ? 'checked="checked"' : "" ?> value="true"/>
            <br/>
            <label for="flagSoprintendenza">Coinvolge Soprintendenza</label>
            <input type="checkbox" id="flagSoprintendenza" name="flagSoprintendenza" <?= $pratica->getFlagSoprintendenza() ? 'checked="checked"' : "" ?> value="true"/>
            <br/>
            <label for="flagInAttesa">In attesa</label>
            <input type="checkbox" id="flagInAttesa" name="flagInAttesa" <?= $pratica->getFlagInAttesa() ? 'checked="checked"' : "" ?> value="true"/>
            <br/>
            <label for="motivoAttesa">Motivo dell'attesa</label>
            <textarea id="motivoAttesa" name="motivoAttesa" ><?php $pratica->getMotivoAttesa(); ?></textarea>
            <br/>
        </div>

        <button type="submit" id="salva" value="pratica">Salva</button>
        <br/>
    </form>
</div>

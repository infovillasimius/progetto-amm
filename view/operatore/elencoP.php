<div class="elencoP">
    <h3>Elenco Pratiche - Ricerca</h3>
    <table class="elencoP">
        <tr>
            <th><label for="numeroP">Numero Pratica</label></th>
            <th><label for="statoPratica">Stato pratica</label></th>
            <th><label for="tipoPratica">Tipo pratica</label></th>
            <th><label for="incaricato">Incaricato</label></th>
            <th><label for="flagAllaFirma">Alla firma</label></th>
            <th><label for="flagFirmata">Firmata</label></th>
            <th><label for="flagSoprintendenza">MIBAC</label></th>
            <th><label for="flagInAttesa">In attesa</label></th>
        </tr>

        <tr>
            <td>
                <input type="text" id="numeroP" name="numeroP" />
            </td>
            <td>
                <select id="statoPratica" name="statoPratica">
                    <option value="0">Tutti</option>
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
            </td>
            <td>
                <select id="tipoPratica" name="tipoPratica">
                    <option value="0">Tutte</option>
                    <option value="1" <?= $pratica->getTipoPratica() == "1" ? 'selected="selected"' : "" ?> >Immediato avvio - 0 gg</option>
                    <option value="2" <?= $pratica->getTipoPratica() == "2" ? 'selected="selected"' : "" ?> >Immediato avvio - 20 gg</option>
                    <option value="3" <?= $pratica->getTipoPratica() == "3" ? 'selected="selected"' : "" ?> >Conferenza di Servizi</option>
                </select>
            </td>
            <td>
                <select id="incaricato" name="incaricato" <?= $ruolo < 2 ? "disabled" : "" ?>>
                    <option value="0" >Tutti</option>
                    <?php
                    if ($ruolo < 2) {
                        $pratica->setIncaricato($operatore->getId());
                    }
                    for ($x = 0; $x < $rows; $x++) {
                        if ($operatori[$x]->getFunzione() <= OperatoreFactory::protocollo()) {
                            echo '<option value="' . $operatori[$x]->getId() . '" ' .
                            ($pratica->getIncaricato() == $operatori[$x]->getId() ? 'selected="selected"' : " ") .
                            '>' . $operatori[$x]->getNominativo() . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagAllaFirma" name="flagAllaFirma" <?= $pratica->getFlagAllaFirma() ? 'checked="checked"' : "" ?> />   
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagFirmata" name="flagFirmata" <?= $pratica->getFlagFirmata() ? 'checked="checked"' : "" ?>  />   
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagSoprintendenza" name="flagSoprintendenza" <?= $pratica->getFlagSoprintendenza() ? 'checked="checked"' : "" ?> />
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagInAttesa" name="flagInAttesa" <?= $pratica->getFlagInAttesa() ? 'checked="checked"' : "" ?> />
            </td>
        </tr>
    </table>
    <br/>
    <table class="result" >
        <tr class="h">
            <th>Numero</th><th>Data Pratica</th><th>Richiedente</th><th>Tipo pratica</th><th>Stato pratica</th><th>Incaricato</th>
        </tr>  
    </table>   

</div>


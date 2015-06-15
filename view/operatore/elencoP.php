<div class="elencoP">
    <h3>Elenco Pratiche - Ricerca</h3>
    <form>
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
                    <option value="1">Caricata su Sardegna Suap</option>
                    <option value="2">Protocollata</option>
                    <option value="3">Assegnata a operatore</option>
                    <option value="4">In attesa di Verifica formale</option>
                    <option value="5">In attesa di Avvio procedimento</option>
                    <option value="6">In attesa di Rilascio ricevuta</option>
                    <option value="7">In attesa di Invio per verifiche ad enti terzi</option>
                    <option value="8">In attesa di integrazioni rich. da enti terzi</option>
                    <option value="9">Conferenza servizi -> Attesa pareri</option>
                    <option value="10">Conferenza servizi -> Convocata</option>
                    <option value="11">Conferenza servizi -> Aperta</option>
                    <option value="12">Conferenza servizi -> Verbalizzata</option>
                    <option value="13">Conferenza servizi -> Provvedimento unico</option>
                    <option value="14">Chiusa -> Esito Positivo</option>
                    <option value="15">Chiusa -> Archiviata</option>
                </select>
            </td>
            <td>
                <select id="tipoPratica" name="tipoPratica">
                    <option value="0">Tutte</option>
                    <option value="1">Immediato avvio - 0 gg</option>
                    <option value="2">Immediato avvio - 20 gg</option>
                    <option value="3">Conferenza di Servizi</option>
                </select>
            </td>
            <td>
                <select id="incaricato" name="incaricato" <?= $ruolo < 2 ? "disabled" : "" ?>>
                    <option value="0" >Tutti</option>
                    <?php
                    if ($ruolo < 2) {
                        $incaricato=($operatore->getId());
                    }
                    for ($x = 0; $x < $rows; $x++) {
                        if ($operatori[$x]->getFunzione() <= OperatoreFactory::protocollo()) {
                            echo '<option value="' . $operatori[$x]->getId() . '" ' .
                            '>' . $operatori[$x]->getNominativo() . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagAllaFirma" name="flagAllaFirma" />   
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagFirmata" name="flagFirmata"  />   
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagSoprintendenza" name="flagSoprintendenza" />
            </td>
            <td>
                <input class="flag" type="checkbox" id="flagInAttesa" name="flagInAttesa" />
            </td>
        </tr>
        <tr>
            
        </tr>
    </table>
    <br/>
    <table class="result" >
        <tr class="h">
            <th>Numero</th><th>Data Pratica</th><th>Richiedente</th><th>Tipo pratica</th><th>Stato pratica</th><th>Incaricato</th>
        </tr>  
    </table>
    <br/>
    <button type="reset" id="reset">Reset</button>
    <button type="submit" id="change">Modo 1</button>
    <button type="submit" id="change2">Modo 2</button>
    <button type="submit" id="Avanti">Avanti</button>
    <button type="submit" id="Indietro">Indietro</button>
    </form>
</div>


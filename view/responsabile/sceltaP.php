<div class="aggiornaP">
    <h3>Firma pratica</h3>

    <form method="post" action="index.php?page=responsabile&amp;cmd=firmaP">
        <label for="numeroP">Numero Pratica</label>
        <input type="text" id="numeroP" name="numeroP" />
        <button type="submit">Apri</button>
    </form>
    <?php
    if ($pagina->getMsg() != "") {
        echo '<p class="aggiornaP">' . $pagina->getMsg() . '</p>';
    }
    ?>
    <br/>

</div>
<div class="elencoP">
    <table class="result" >
        <tr class="h">
            <th>Numero</th><th>Data Pratica</th><th>Richiedente</th><th>Tipo pratica</th><th>Stato pratica</th><th>Incaricato</th>
        </tr>  
    </table>
</div>


<div class="aggiornaP">
    <h3>Aggiornamento pratica</h3>
    <br/>
    <br/>
    <form method="post" action="index.php?page=operatore&cmd=aggiornaP">
        <label for="numeroP">Numero Pratica</label>
        <input type="text" id="numeroP" name="numeroP" />
        <button type="submit">Edit</button>
    </form>
    <?php
    if ($pagina->getMsg() != "") {
        echo '<p class="aggiornaP">' . $pagina->getMsg() . '</p>';
    }
    ?>
</div>




<div class="upload">
    <h3>Gestione files allegati alla pratica n. <?= $numeroP ?></h3>
    
    <form action="index.php?page=responsabile&amp;cmd=uploadF" method="post" enctype="multipart/form-data">
        <label for="FileToUpload">Seleziona il file da caricare:</label><br/><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/><br/>
        <input type="submit" value="Carica file" name="submit">
        <input type="hidden" name="numeroP" value="<?php echo $numeroP ?>" />
    </form>
    
        <h3>Elenco files allegati alla pratica n. <?= $numeroP ?></h3>
    
    <?php ResponsabileController::ScanDirectory('./files/uploads/' . $numeroP); ?>
    <p id="uploadMsg" class="uploadMsg"><?php echo $pagina->getMsg(); ?></p>
</div>



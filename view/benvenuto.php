<div class="benvenuto">
    <h3>
        Ciao <?php echo $operatore->getNome() ?>
    </h3>
   
    <p>Il totale dei diritti incassati dal giorno 11/05/2015 ad oggi è € <?php echo PraticaFactory::totaleDiritti(); ?> 
        <br> e sono state caricate <?php echo PraticaFactory::numeroTotalePratiche(); ?> pratiche.</p>
    
    <table class="statistiche">
        <tr>
            <th>Comune</th><th>Castiadas</th><th>Muravera</th><th>San Vito</th><th>Villaputzu</th><th>Villasimius</th>
        </tr>
                  
        <tr class="b">
            <td>Imm. avvio (0 gg)</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(1,1); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(2,1); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(3,1); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(4,1); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(5,1); ?></td>
        </tr>
        
        <tr class="a">
            <td>Imm. avvio (20 gg)</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(1,2); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(2,2); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(3,2); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(4,2); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(5,2); ?></td>
        </tr>
        
        <tr class="b">
            <td>Conf. di servizi</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(1,3); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(2,3); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(3,3); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(4,3); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipo(5,3); ?></td>
        </tr>
        
        <tr class="a">
            <td>Totale pratiche</td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComune(1); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComune(2); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComune(3); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComune(4); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComune(5); ?></td>
        </tr>
        
    </table>
    
    <p>Per l'anno <?php echo date('Y'); ?>:</p>
    
    <table class="statistiche">
        <tr>
            <th>Comune</th><th>Castiadas</th><th>Muravera</th><th>San Vito</th><th>Villaputzu</th><th>Villasimius</th>
        </tr>
                  
        <tr class="b">
            <td>Imm. avvio (0 gg)</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(1,1,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(2,1,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(3,1,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(4,1,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(5,1,date('Y')); ?></td>
        </tr>
        
        <tr class="a">
            <td>Imm. avvio (20 gg)</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(1,2,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(2,2,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(3,2,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(4,2,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(5,2,date('Y')); ?></td>
        </tr>
        
        <tr class="b">
            <td>Conf. di servizi</td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(1,3,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(2,3,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(3,3,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(4,3,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroPraticheComunePerTipoPerAnno(5,3,date('Y')); ?></td>
        </tr>
        
        <tr class="a">
            <td>Totale pratiche</td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComunePerAnno(1,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComunePerAnno(2,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComunePerAnno(3,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComunePerAnno(4,date('Y')); ?></td>
            <td><?php echo PraticaFactory::numeroTotalePraticheComunePerAnno(5,date('Y')); ?></td>
        </tr>
        
    </table>
    
    <p><?php echo $pagina->getMsg(); ?></p>
</div>
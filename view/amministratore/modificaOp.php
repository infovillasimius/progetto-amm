
<div class="listaOp">
    <h3>Lista operatori</h3>
    <table class="listaOp">
        <tr>
            <th>Nome</th>
            <th>Username</th>
            <th>Funzione</th>
            <th>Azione</th>
        </tr>
    <?php           
        for($x=0;$x<$rows;$x++){
            echo '<tr class="'.(($x%2)==1 ?'a':'b').'">';
            echo "<td>".$operatori[$x]->getNominativo() . "</td>"
               . "<td>".$operatori[$x]->getUsername(). "</td>"
               . "<td>".  OperatoreFactory::ruolo($operatori[$x]->getFunzione())."</td>"
               . '<td class="center"><form method="post" action="index.php?page=admin&amp;cmd=modificaOp">'
               . '<button type="submit">Edit</button><input type="hidden" name="id" value="'.$operatori[$x]->getId().'" /></form></td>';
            echo "</tr>";
            
        }
    ?>
    </table>
    
</div>


    
    
